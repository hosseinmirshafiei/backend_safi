<?php

namespace App\Http\Controllers\Market\Biography;

use App\Http\Controllers\Controller;
use App\Models\Biography;
use Illuminate\Http\Request;

class BiographyController extends Controller
{
    public function index(){
        $biography = Biography::first();
        return response()->json($biography);
    }
}
