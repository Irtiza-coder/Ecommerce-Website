<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'mobile'  => 'required|string|max:20',
            'email'   => 'required|email|max:255',
            'message' => 'nullable|string',
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->mobile = $request->mobile;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();

        return redirect('/contact-us')->with('message', 'Thank you! Your message has been sent successfully. We will contact you soon.');
    }
}