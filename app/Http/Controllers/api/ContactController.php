<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use Validator;
use GuzzleHttp\Client;

class ContactController extends Controller
{
    public function CEPValidator($cep)
    {
        $newcep = preg_replace("/[^0-9]/", "", $cep);
        $client = new Client();
        $request = new \GuzzleHttp\Psr7\Request('GET', 'https://viacep.com.br/ws/' . $newcep . "/json");
        $response = $client->send($request);
        $json = json_decode($response->getBody(), true);
        if (isset($json['erro'])) {
            return false;
        }
        return true;
    }
    public function alreadyRegistered($userID, $phone, $email)
    {
        $contactPhone =
            Contact::all()
            ->where('user_id', $userID)
            ->where('phone', $phone)
            ->count();
        if ($contactPhone > 0) return [true, 'You already have a contact with this phone number'];
        $contactEmail =
            Contact::all()
            ->where('user_id', $userID)
            ->where('email', $email)
            ->count();
        if ($contactEmail > 0) return [true, 'You already have a contact with this email'];

        return [false, 'Success'];
    }
    public function index()
    {
        $user = Auth::user();
        return response()->json(['contacts' => $user->contacts], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|between:6,60',
            'email' => 'nullable|email',
            'address' => 'nullable',
            'CEP' => 'size:10',
            'phone' => 'min:14|max:15'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        if (!self::CEPValidator($request->input('CEP'))) {
            return response()->json(['error' => 'invalid CEP'], 401);
        } else {
            $registered = self::alreadyRegistered(Auth::user()->id, request('phone'), request('email'));
            if ($registered[0]) {
                return response()->json(['error' => $registered[1]], 401);
            }
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
    }


    public function show($id)
    {
        $contact =  Contact::all()
            ->where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->first();
        return $contact;
    }


    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|between:6,60',
            'email' => 'nullable|email',
            'address' => 'nullable',
            'CEP' => 'size:10',
            'phone' => 'min:14|max:15'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        if (!self::CEPValidator($request->input('CEP'))) {
            return response()->json(['error' => 'invalid CEP'], 401);
        } else {
            $user = Auth::user();
            $contact = $user->contacts()
                ->where('id', $id)
                ->first();
            if (!$contact) return response()->json(['error' => 'Contact not found!'], 401);
            $contact->update($request->all());
            return response()->json(['success' => 'Contact updated'], 201);
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $contact =  $user->contacts()
            ->where('id', $id)
            ->first();
        if (!$contact) return response()->json(['error' => 'Contact not found!'], 401);
        $contact->delete();
    }
    public function search(Request $request)
    {
        $user = Auth::user();
        $contacts =  $user->contacts()
                                ->where('name', 'like', '%'. request('query') . '%')
                                ->orWhere('address', 'like', '%'. request('query') . '%')
                                ->orWhere('email', 'like', '%'. request('query') . '%')
                                ->get();

        return response()->json(['contacts' => $contacts], 201);
    }
}
