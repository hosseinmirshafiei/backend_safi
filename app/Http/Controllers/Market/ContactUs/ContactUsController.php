<?php

namespace App\Http\Controllers\Market\ContactUs;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index(){
         $contact = Contact::first();
         return response()->json($contact);
    }
}
