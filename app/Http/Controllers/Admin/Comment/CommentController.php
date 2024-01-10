<?php

namespace App\Http\Controllers\Admin\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CommentRequest;
use App\Models\Comment;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class CommentController extends Controller
{
  public function index(CommentRequest $request){
    $req = $request->all();
    $lastId = $req["last_id"];
    $page = $req["page"];

    $comments = Comment::when($page == 1, function ($query) {
        $query->where('id', ">", 0);
      })
      ->when($page != 1, function ($query) use ($lastId) {
        $query->where('id', "<", $lastId);
      })
      ->with("user")
      ->orderBy('id', 'desc')
      ->limit(100)
      ->get();
      return response()->json($comments);
  }

  public function status(CommentRequest $request){

    $req = $request->all();
    $id = $req["id"];
    $comment = Comment::where("id", $id)->with("child", "parent" ,"user")->get()->first();
    if(!empty($comment)){
        if($comment->status == 0){
            $status = ["status" => 1];
        }
        else{
            $status = ["status" => 0];
        }
      $comment->update($status);
      $comment_updated = Comment::where("id", $id)->with("child", "parent" ,"user")->get()->first();
      return response()->json($comment_updated);
    }
  }

  public function show(CommentRequest $request){
    $req = $request->all();
    $id = $req["id"];
    $comment  = Comment::where("id" , $id)->with("child.user" , "parent" , "user")->get()->first();
    return response()->json($comment);
  }

  public function create(CommentRequest $request){

    $req = $request->all();
    $user = User::checkLogin();
    $req["user_id"] = $user->id;   //bayad taghir konad ba token auth
    $req["status"] = 1;
    $comment = Comment::create($req);
    $comment_create = Comment::where("id" , $comment->id)->with("child" , "parent" , "user")->get()->first();
    return response()->json($comment_create);
  }
}
