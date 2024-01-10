<?php

namespace App\Http\Controllers\Admin\Delivery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryRequest;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        $delivery = Delivery::first();
        return response()->json($delivery);
    }

    public function create(DeliveryRequest $request)
    {
        $req = $request->all();
        ///
        $convert_list=['sefareshiBase', 'pishtazBase', 'sefareshiWeight', 'pishtazWeight'];
        foreach($convert_list as $item){
            $converted = convertPersianToEnglish($req[$item]);
            $req[$item] = convertArabicToEnglish($converted);
        }
        ////
        $delivery = Delivery::first();
        if (empty($delivery)) {
            Delivery::create($req);
        } else {
            $delivery->update($req);
        }
        $delivery_updated = Delivery::first();
        return response()->json($delivery_updated);
    }

    public function status()
    {
        $delivery = Delivery::first();
        if (empty($delivery)) {
            Delivery::create(["status" => 1]);
        } else {
            $status = $delivery->status;
            if ($status == 0) {
                $delivery->update(["status" => 1]);
            } else {
                $delivery->update(["status" => 0]);
            }
        }
        $delivery_updated = Delivery::first();
        return response()->json($delivery_updated);
    }
}
