<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ContactsController extends Controller
{
    public function index()
    {
        return view("contacts.index", [
            "contacts" => Contact::where("user_id", Auth::id())->get()
        ]);
    }
}
