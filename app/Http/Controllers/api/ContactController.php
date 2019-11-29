<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return response()->json(['contacts' => $user->contacts], 200);

    }

    public function store(Request $request)
    {
        $user = Auth::user();
        //TODO - all fields validation, validate CEP using external API
        Contact::create([
            'name' => request('name'),
            'address' => request('address'),
            'CEP' => request('CEP'),
            'phone' => request('phone'),
            'email' => request('email'),
            'user_id' => Auth::user()->id
        ]);
        return response()->json(['success' => 'Contact created'], 201);

    }


    public function show($id)
    {
        //TODO -  verify if the logged user is the owner of the selected contact
        return Contact::findOrFail($id);
    }


    public function update(Request $request, $id)
    {
        //TODO -  verify if the logged user is the owner of the selected contact
        $contact =  Contact::findOrFail($id);
        $contact->update($request->all());
    }

    public function destroy($id)
    {
        //TODO -  verify if the logged user is the owner of the selected contact
        $contact =  Contact::findOrFail($id);
        $contact->delete();
    }
}
