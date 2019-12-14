<?php

namespace App\Http\Controllers\Backend;

use App\Models\Comment;
use App\Models\Product;
use App\Models\ReplyComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $comments = Comment::getListAllComment();
//        $product = Product::getCommentOfUser();
        $params = $request->all();
        $comments = Comment::getDistinct($params);

        return view('backend.pages.comment.index', compact('comments', 'products'));
    }

    public function reply(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();

            DB::beginTransaction();
            $replyComment = ReplyComment::replyComment($input);
            if ($replyComment) {
                DB::commit();
                return response()->json(['success' => 'yes'], 200);
            } else {
                DB::rollBack();
            }
        }
    }

    public function detail(Request $request)
    {
        if ($request->ajax()) {
            $productId = $request->get('product_id');
            $userId = $request->get('user_id');
            $comments = Comment::getCommentByUserIdAndProductId($userId, $productId);

            $html = view('backend.pages.comment._comment', compact('comments'))->render();

            return response()->json(['html' => $html, 'countItem' => count($comments)], 200);
        }
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax()) {
            $comment = Comment::findOrFail($id);

            if ($comment->delete()) {
                ReplyComment::where('comment_id', $id)->delete();

                return response()->json(['success' => 'yes'], 200);
            }
        }
    }

    public function deleteReply(Request $request, $id)
    {
        if ($request->ajax()) {
            $repComment = ReplyComment::findOrFail($id);

            if ($repComment->delete()) {
                return response()->json(['success' => 'yes'], 200);
            }
        }
    }
}
