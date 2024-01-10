<?php

namespace App\Http\Controllers\Admin\Discount;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GeneralDiscountRequest;
use App\Models\GeneralDiscount;
use Illuminate\Http\Request;

class GeneralDiscountController extends Controller
{

    public function index(){
        $generalDiscount =  GeneralDiscount::first();
        return response()->json($generalDiscount);
    }

    public function create(GeneralDiscountRequest $request)
    {
        $req = $request->all();
        ///
        $convert_list = ['percent_discount', 'maximum_discount'];
        foreach ($convert_list as $item) {
            if($req[$item] == null){
              break;
            }else{
                $converted = convertPersianToEnglish($req[$item]);
                $req[$item] = convertArabicToEnglish($converted);
            }
        }
        ////
        if($req['start_discount'] < $req['finish_discount']){
        $discount = GeneralDiscount::first();
        if (empty($discount)) {
            GeneralDiscount::create($req);
        } else {
            $discount->update($req);
        }
        $discount_updated = GeneralDiscount::first();
        
        return response()->json($discount_updated);
        }
    }

    public function status()
    {
        $discount = GeneralDiscount::first();
        if (empty($discount)) {
            GeneralDiscount::create(["status" => 1]);
        } else {
            $status = $discount->status;
            if ($status == 0) {
                $discount->update(["status" => 1]);
            } else {
                $discount->update(["status" => 0]);
            }
        }
        $discount_updated = GeneralDiscount::first();
        return response()->json($discount_updated);
    }
}
