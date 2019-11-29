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
        return self::create($request);
    }

    public static function getCommentReply($comment_id)
    {
        return self::where('comment_id', $comment_id)->get();
    }
}
