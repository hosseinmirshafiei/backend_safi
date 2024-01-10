<?php

namespace App\Http\Controllers\Market\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\Market\AddressRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function create(AddressRequest $request)
    {
        $user = User::checkLogin();
        $user_id = $user->id;
        $req = $request->all();
        ///////////// create address
        $req['user_id'] = $user_id;
        $req['active'] = 1;
        $new_address = Address::create($req);

        $address_old = Address::where('user_id', $user_id)->where('id', '!=', $new_address->id)->get();
        foreach ($address_old as $item) {
            $item->active = 0;
            $item->save();
        }

        $address = Address::where('user_id', $user_id)->orderBy('active', 'desc')->orderBy('id', 'desc')->get();
        $address_active = $address[0];
        $address_user = ["address" => $address, "address_active" => $address_active];
        return response()->json($address_user);
    }
    public function update(AddressRequest $request)
    {
        $user = User::checkLogin();
        $user_id = $user->id;
        $req = $request->all();
        Address::where('user_id', $user_id)->where('id', $req['id'])->update($req);
        ///
        $address = Address::where('user_id', $user_id)->orderBy('active', 'desc')->orderBy('id', 'desc')->get();
        $address_active = $address[0];
        $address_user = ["address" => $address, "address_active" => $address_active];
        return response()->json($address_user);
    }

    public function switch(AddressRequest $request)
    {
        $user = User::checkLogin();
        $user_id = $user->id;
        $req = $request->all();
        //////
        Address::where('id', $req['id'])->update(['active' => 1]);
        $address_old = Address::where('user_id', $user_id)->where('id', '!=', $req['id'])->get();
        foreach ($address_old as $item) {
            $item->active = 0;
            $item->save();
        }
        ///////
        $address = Address::where('user_id', $user_id)->orderBy('active', 'desc')->orderBy('id', 'desc')->get();
        $address_active = $address[0];
        $address_user = ["address"=>$address, "address_active"=>$address_active];

        return response()->json($address_user);
    }

}
