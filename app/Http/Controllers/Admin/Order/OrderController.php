<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrdersRequest;
use App\Http\Requests\Market\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(OrdersRequest $request)
    {
        $req = $request->all();
        $mobile = $req['mobile'];
        $lastId = $req["last_id"];
        $page = $req["page"];

        $orders = Order::when($mobile != null, function ($query) use ($mobile) {
            $query->whereHas("user", function ($query) use ($mobile) {
                $query->where('mobile', 'LIKE', "%$mobile%");
            })->orWhereHas("address", function ($query) use ($mobile) {
                $query->where('mobile', 'LIKE', "%$mobile%");
            });
        })
            ->when($page == 1, function ($query) {
                $query->where('id', ">", 0);
            })
            ->when($page != 1, function ($query) use ($lastId) {
                $query->where('id', "<", $lastId);
            })
            ->with("user", "address")
            ->orderBy('id', 'desc')
            ->limit(100)
            ->get();

        return response()->json($orders);
    }

    public function checked(OrdersRequest $request){
        $order_id = $request["order_id"];
        Order::where("id",$order_id)->update(["checked" => 1]);
        return response()->json("success");
    }
    public function ordersUser(OrdersRequest $request){
        $user_id = $request["user_id"];
        $orders = Order::where("user_id" , $user_id)->with("address" , "user")->get();
        return response()->json($orders);
    }
}
