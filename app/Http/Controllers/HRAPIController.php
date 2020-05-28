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
        return response()->json(json_decode((string) $body));
    }
}
