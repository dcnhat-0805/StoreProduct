<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CommentController extends FrontEndController
{
    public function sendComment(CommentRequest $request)
    {
        $user = Auth::user();
        $input = $request->all();

        if (!$user) {
            return redirect()->route(FRONT_END_HOME_INDEX);
        }
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->product_id = $input['product_id'];
        $comment->comment_contents = $input['comment_contents'];
        $comment->type = CUSTOMER_ASK;

        DB::beginTransaction();
        if ($comment->save()) {
//            Session::flash("success", trans("messages.users.update_success"));

            DB::commit();
            return back();
        } else {
            DB::rollBack();
        }
    }
}
