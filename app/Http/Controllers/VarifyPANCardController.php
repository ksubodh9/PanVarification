<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Libraries\DateTime;

class VarifyPANCardController extends Controller
{
    public function verifyPan(Request $request)
    {
       
        $header = json_encode([
            'alg' => 'HS256',
            'typ' => 'JWT'
        ]);

        $payload = json_encode([
            'partnerId' => 'CORP00001', 
            'timestamp' => time(),
            'reqid'=>mt_rand(10000, 99999),
        ]);
       
        $secret = 'UTA5U1VEQXdNREF4VFZSSmVrNUVWVEpPZWxVd1RuYzlQUT09';

        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);

        $signature = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, $secret, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);

        $jwtToken = $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;

        $client = new Client();
      

        $response = $client->request('POST', 'https://uat.paysprint.in/sprintverify-uat/api/v1/verification/pan_comprehensive', [
            'body' => '{"pan_number":"' . $request->pan_number . '"}',
          'headers' => [
            'Token' => $jwtToken,
            'accept' => 'application/json',
            'authorisedkey' => 'TVRJek5EVTJOelUwTnpKRFQxSlFNREF3TURFPQ==',
            'content-type' => 'application/json',
          ],
        ]);
        
       
        $data = json_decode($response->getBody(), true);

        return redirect()->back()->with('data', $data);
    }

    private function base64UrlEncode($data)
    {
        $base64 = base64_encode($data);
        return rtrim(strtr($base64, '+/', '-_'), '=');
    }

    public function index()
    {
        return view('welcome');
    }
}
