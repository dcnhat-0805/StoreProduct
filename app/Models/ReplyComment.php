<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReplyComment extends Model
{
    protected $table = 'reply_comments';

    protected $fillable = [
        'comment_id', 'comment_reply', 'comment_type',
    ];

    public static function replyComment($request)
    {
        $repCommentId = $request['rep_comment_id'];
        unset($request['rep_comment_id']);
        if ($repCommentId) {
            $repComment = self::findOrFail($repCommentId);

            return $repComment->update($request);
        }

        return self::create($request);
    }

    public static function getCommentReply($comment_id)
    {
        return self::where('reply_comments.comment_id', $comment_id)
            ->join('comments', 'reply_comments.comment_id', '=', 'comments.id')
            ->select(
                'reply_comments.id',
                'reply_comments.comment_id',
                'reply_comments.comment_reply',
                'reply_comments.comment_type',
                'reply_comments.created_at',
                'comments.product_id',
                'comments.user_id'
            )
            ->get();
    }
}
