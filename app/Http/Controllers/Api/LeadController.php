<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Support\Facades\Validator;
use App\Mail\NewContact;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    public function store(Request $request) {

        // ricevere i dati della nostra form
        $data = $request->all();

        // richieste di validazione
        $validator = Validator::make($data, [
            'name' => 'required|max:50',
            'surname' => 'required|max:50',
            'phone' => 'required|max:15',
            'email_address' => 'required|max:50',
            'content' => 'required',
        ],
        $errors = [
            'name.required' => 'Il nome è obbligatorio',
            'name.max' => 'Il nome non può superare :max caratteri',
            'surname.required' => 'Il cognome è obbligatorio',
            'surname.max' => 'Il cognome non può superare :max caratteri',
            'phone.required' => 'Il numero di telefono è obbligatorio',
            'phone.max' => 'Il numero di telefono non può superare 15 caratteri',
            'email_address.required' => 'L\'indirizzo email è obbligatorio',
            'email_address.max' => 'L\'indirizzo email non può superare :max caratteri',
            'content.required' => 'Il contenuto è obbligatorio',
        ]);

        // verifica di eventuali errori nella form
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        // creare un nuovo record Lead memorizzarlinel DB
        $new_lead = new Lead();
        $new_lead->fill($data);
        $new_lead->save();

        // inviare la mail
        Mail::to('hello@example.com')->send(new NewContact($new_lead));

        return response()->json([
            'success' => true,
        ]);
    }
}
