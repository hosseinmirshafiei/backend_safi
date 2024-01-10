<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsersRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(UsersRequest $request){
        $req = $request->all();
        $mobile = $req['mobile'];
        $lastId = $req["last_id"];
        $page = $req["page"];

        $users = User::when($mobile != null, function ($query) use ($mobile) {
            $query->where('mobile', 'LIKE', "%$mobile%");
        })
            ->when($page == 1, function ($query) {
                $query->where('id', ">", 0);
            })
            ->when($page != 1, function ($query) use ($lastId) {
                $query->where('id', "<", $lastId);
            })
            ->orderBy('id', 'desc')
            ->limit(100)
            ->get();
        return response()->json($users);
    }
}
