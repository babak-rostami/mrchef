<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * پیش‌فرض یه کامنتِ اصلی (top-level) روی یه Recipe تازه‌ساخته‌ست.
     */
    public function definition(): array
    {
        return [
            'commentable_id' => Recipe::factory(),
            'commentable_type' => Recipe::class,
            'user_id' => User::factory(),
            'body' => $this->faker->sentence(),
        ];
    }

    /**
     * یه پاسخِ مستقیم به یه کامنتِ مشخص. طبق ساختارِ مسطحِ پاسخ‌ها
     * (نگاه کن به docs/comments-system.md)، یه پاسخ اصلاً commentable_*
     * نداره — فقط parent_id داره.
     */
    public function replyTo(Comment $parent): static
    {
        return $this->state(fn() => [
            'commentable_id' => null,
            'commentable_type' => null,
            'parent_id' => $parent->id,
            'reply_id' => null,
        ]);
    }
}
