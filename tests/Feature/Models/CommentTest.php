<?php

use App\Models\CkeditorImage;
use App\Models\Comment;
use App\Models\CommentReaction;
use App\Models\Recipe;
use App\Services\Editor\EditorService;
use Illuminate\Support\Facades\Storage;

test('a freshly instantiated comment defaults its counters to zero', function () {
    // این پیش‌فرض‌ها روی خودِ مدل (نه فقط ستونِ دیتابیس) تعریف شدن تا
    // بلافاصله بعد از ساختِ AJAX یه کامنتِ تازه، بلید عددِ «۰» رو نشون
    // بده، نه یه جای خالی — نگاه کن به کامنتِ خودِ Comment::$attributes
    $comment = new Comment();

    expect($comment->like_count)->toBe(0);
    expect($comment->dislike_count)->toBe(0);
    expect($comment->reply_count)->toBe(0);
});

test('isReply is false for a top-level comment and true for a reply', function () {
    $topLevel = Comment::factory()->create();
    $reply = Comment::factory()->replyTo($topLevel)->create();

    expect($topLevel->isReply())->toBeFalse();
    expect($reply->isReply())->toBeTrue();
});

test('a top-level comment is polymorphically attached to its commentable model', function () {
    $recipe = Recipe::factory()->create();
    $comment = Comment::factory()->create([
        'commentable_id' => $recipe->id,
        'commentable_type' => Recipe::class,
    ]);

    expect($comment->commentable->is($recipe))->toBeTrue();
});

test('a reply has no commentable at all — only a parent_id ties it to anything', function () {
    $topLevel = Comment::factory()->create();
    $reply = Comment::factory()->replyTo($topLevel)->create();

    expect($reply->commentable_id)->toBeNull();
    expect($reply->commentable_type)->toBeNull();
    expect($reply->parent->is($topLevel))->toBeTrue();
});

test('replyTo points at the exact comment that was answered, even for a reply-to-a-reply', function () {
    // ساختار پاسخ‌ها مسطحه: parent_id همیشه کامنتِ اصلیه، ولی reply_id
    // دقیقاً مشخص می‌کنه به کدوم پاسخ جواب داده شده — این دو باید وقتی
    // داریم به یه پاسخ جواب میدیم (نه به خودِ کامنتِ اصلی) فرق کنن
    $topLevel = Comment::factory()->create();
    $firstReply = Comment::factory()->replyTo($topLevel)->create();

    $secondReply = Comment::factory()->create([
        'parent_id' => $topLevel->id,
        'reply_id' => $firstReply->id,
    ]);

    expect($secondReply->parent->is($topLevel))->toBeTrue();
    expect($secondReply->replyTo->is($firstReply))->toBeTrue();
});

test('repliesForDisplay orders oldest-first, the opposite of top-level comments', function () {
    $topLevel = Comment::factory()->create();
    $firstReply = Comment::factory()->replyTo($topLevel)->create(['created_at' => now()->subMinutes(10)]);
    $secondReply = Comment::factory()->replyTo($topLevel)->create(['created_at' => now()]);

    expect($topLevel->repliesForDisplay->pluck('id')->all())->toBe([$firstReply->id, $secondReply->id]);
});

test('a comment has many reactions', function () {
    $comment = Comment::factory()->create();

    CommentReaction::create(['comment_id' => $comment->id, 'visitor_id' => str_repeat('a', 32), 'reaction' => 'like']);
    CommentReaction::create(['comment_id' => $comment->id, 'visitor_id' => str_repeat('b', 32), 'reaction' => 'dislike']);

    expect($comment->reactions)->toHaveCount(2);
});

// ------------------------------------------------------------------
// منطقِ CommentObserver: فقط کامنتِ اصلی، و فقط وقتی content واقعاً
// تغییر کرده، باید EditorService::sync رو صدا بزنه. به‌جای چک‌کردنِ
// غیرمستقیمِ عوارضِ جانبی، دقیقاً همین قانون رو با mock کردنِ
// EditorService تست می‌کنیم.
// ------------------------------------------------------------------

test('updating content on a top-level comment triggers EditorService::sync for the content field', function () {
    $comment = Comment::factory()->create();

    $this->mock(EditorService::class, function ($mock) use ($comment) {
        $mock->shouldReceive('sync')
            ->once()
            ->with(Mockery::on(fn($arg) => $arg->is($comment)), 'content');
    });

    $comment->update(['content' => '<p>متن ویرایش‌شده</p>']);
});

test('updating content on a reply never triggers EditorService::sync — replies never get an editor', function () {
    $topLevel = Comment::factory()->create();
    $reply = Comment::factory()->replyTo($topLevel)->create();

    $this->mock(EditorService::class, function ($mock) {
        $mock->shouldNotReceive('sync');
    });

    $reply->update(['content' => '<p>تلاش برای گذاشتن محتوای ادیتور روی یه پاسخ</p>']);
});

test('updating a comment without touching content does not trigger EditorService::sync', function () {
    $comment = Comment::factory()->create(['content' => null]);

    $this->mock(EditorService::class, function ($mock) {
        $mock->shouldNotReceive('sync');
    });

    $comment->update(['body' => 'فقط متن ساده عوض شد']);
});

test('deleting a comment removes its editor images from the database', function () {
    Storage::fake('ftp');

    $comment = Comment::factory()->create();
    $editorImages = CkeditorImage::factory()->count(2)->forModel($comment)->create();

    $comment->delete();

    foreach ($editorImages as $editorImage) {
        expect(CkeditorImage::find($editorImage->id))->toBeNull();
    }
});
