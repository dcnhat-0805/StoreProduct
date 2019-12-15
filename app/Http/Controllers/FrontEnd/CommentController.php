<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Rating;
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

            if (!empty($input['rating'])) {
                self::updateRating($input);
                $ratePoint = Rating::getRatingByUserIdAndProductId($user->id, $comment->product_id);
            }
//            Session::flash("success", trans("messages.users.update_success"));

            DB::commit();
            return response()->json($ratePoint ?? true);
        } else {
            DB::rollBack();
        }
    }


    public function updateRating($request)
    {
        $user = Auth::user();
        $productId = $request['product_id'];

        $productId = !$productId ? 0 : $productId;
        $product = Product::showProduct($productId);

        if (!$product) {
            return response()->json(0);
        } else {
            $point = $request['rating'];

            $rating = Rating::firstorNew([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $rating->point = $point;
            $rating->save();

//            if ($rating->save()) {
//                $ratePoint = Rating::getRatingByUserIdAndProductId($user->id, $product->id);
//
//                return response()->json($ratePoint);
//            } else {
//                return response()->json(0);
//            }
        }
    }

    public function loadComment($productId)
    {
        $comments = Comment::getDistinctDetailProduct($productId);
        $html = view('frontend.pages.product._comment', compact('comments'))->render();

        return response()->json($html);
    }
}
