<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentReactionController extends Controller
{
    /**
     * Toggle like / dislike reaction for a comment.
     * The same endpoint handles:
     * - first time reaction
     * - removing the same reaction
     * - switching between like and dislike
     */
    public function toggle(Request $request, Comment $comment)
    {
        // Validate incoming reaction type
        $request->validate([
            'reaction' => 'required|in:like,dislike',
        ]);

        // Unique identifier for the current visitor (guest or logged-in)
        $visitorId = $this->visitorId();

        // Requested reaction (like or dislike)
        $reaction = $request->reaction;

        // Run everything inside a database transaction
        // to keep counters and reactions in sync
        DB::transaction(function () use ($comment, $visitorId, $reaction) {

            // Check if this visitor already reacted to this comment
            // lockForUpdate prevents race conditions under high load
            $existing = CommentReaction::where([
                'comment_id' => $comment->id,
                'visitor_id' => $visitorId,
            ])->lockForUpdate()->first();

            /**
             * CASE 1:
             * Visitor has never reacted to this comment before
             */
            if (! $existing) {
                CommentReaction::create([
                    'comment_id' => $comment->id,
                    'visitor_id' => $visitorId,
                    'reaction' => $reaction,
                ]);

                // Increase the corresponding counter (like_count or dislike_count)
                $comment->increment("{$reaction}_count");

                return;
            }

            /**
             * CASE 2:
             * Visitor clicks the same reaction again
             * Example: already liked → clicks like again
             * Result: reaction is removed (toggle off)
             */
            if ($existing->reaction === $reaction) {
                $existing->delete();

                // Decrease the same counter
                $comment->decrement("{$reaction}_count");
                return;
            }

            /**
             * CASE 3:
             * Visitor switches reaction
             * Example: dislike → like OR like → dislike
             */
            $oldReaction = $existing->reaction;

            // Decrease the old reaction counter
            $comment->decrement("{$oldReaction}_count");

            // Increase the new reaction counter
            $comment->increment("{$reaction}_count");

            // Update reaction record
            $existing->update([
                'reaction' => $reaction,
            ]);
        });

        // Always return fresh counts from database
        // One fresh call is enough
        $comment = $comment->fresh();

        return response()->json([
            'like_count' => $comment->like_count,
            'dislike_count' => $comment->dislike_count,
        ]);
    }

    /**
     * Generate and store a stable visitor identifier in session.
     * This works for both guest and logged-in users.
     */
    protected function visitorId(): string
    {
        if (! session()->has('visitor_id')) {
            session()->put(
                'visitor_id',
                substr(hash('sha256', session()->getId()), 0, 32)
            );
        }

        return session()->get('visitor_id');
    }
}
