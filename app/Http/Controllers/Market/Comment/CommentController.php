<?php

namespace App\Http\Controllers\Market\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Market\CommentRequest;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(CommentRequest $request)
    {

        $req = $request->all();
        $user = User::checkLogin();
        if ($user != null) {
            $user_id = $user->id;
        } else {
            $user_id = null;
        }
        $comment_id = $req["comment_id"];
        $product_id = $req["product_id"];
        $comment = $req["comment"];
        $status = 0;
        if ($user->is_admin == 1) {
            $status = 1;
        }
        $comment = Comment::create([
            "user_id" => $user_id,
            "comment_id" => $comment_id,
            "product_id" => $product_id,
            "body" => $comment,
            "status" => $status
        ]);

        //comment
        $comment_created = Comment::where(function ($query) use ($product_id , $comment) {
            $query->where("product_id", $product_id)
                ->where("id", $comment->id);
        })
            ->where(function ($query) use ($user) {
                $query->where("status", 1)
                ->when($user != null, function ($query) use ($user) {
                    $query->orWhere("user_id", $user->id);
                });
            })
            ->with("childs", "user")->get()->first();

        //////
        $response = ["comment" => $comment_created];
        return response()->json($response);
    }

    public function loadMore(CommentRequest $request){

        $product_id = $request["product_id"];
        $last_id = $request["last_id"];
        $user = User::checkLogin();
        $comments = Comment::where(function ($query) use ($product_id) {
            $query->where("product_id", $product_id)
                ->where("comment_id", null);
        })
            ->where(function ($query) use ($user) {
                $query->where("status", 1)
                    ->when($user != null, function ($query) use ($user) {
                        $query->orWhere("user_id", $user->id);
                    });
            })
            ->where("id", "<", $last_id)->take(20)
            ->with("childs", "user")->orderBy("id", "desc")->get();

        //////
        $response = ["comments" => $comments];
        return response()->json($response);
    }
}
