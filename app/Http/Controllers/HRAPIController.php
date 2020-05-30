<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class HRAPIController extends Controller
{
    public function persons(Request $request)
    {
        $client = new Client();
        $response = $client->get(
            env('HR_API_URL') . '/api/persons',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer " . env('HR_API_TOKEN')
                ],
                'query' => $request->query(),
            ]
        );
        $body = $response->getBody();
        $json = json_decode($body);

        foreach ($json->data as $person) {
            unset($person->person_id);
            unset($person->person_type);
            unset($person->senoir_number);
            if (!$request->user()->can('view_personal_data_citizen_id'))
                unset($person->person_id_code);
            if (!$request->user()->can('view_personal_data_religion'))
                unset($person->person_religion);
            if (!$request->user()->can('view_personal_data_birthdate'))
                unset($person->person_birthday);
            if (!$request->user()->can('view_personal_data_health')) {
                unset($person->person_blood_group);
                unset($person->person_weight);
                unset($person->person_height);
            }
        }

        // var_export($json);
        // if $json['data'] 

        return response()->json($json);
    }
}
