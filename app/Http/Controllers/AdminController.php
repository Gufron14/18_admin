<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function update(Request $request)
    {
        // $userLogin = View::shared('userLogin');
        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . session('token')
            ]
        ]);
        // dd($id);
        $validatedData = $request->validate([
            'username' => 'nullable|string|max:255',
            'email' => 'nullable|email:rfc,dns',
            'password' => 'nullable|string|min:3',
            'avatar' => 'nullable|mimes:png,jpg,jpeg',
        ]);
        if ($request->file('avatar')) {
            $pResponse = $client->request('POST', "http://localhost:5000/api/admin/update", [
                'multipart' => [
                    [
                        'name' => 'username',
                        'contents' => $validatedData['username']
                    ],

                    [
                        'name' => 'email',
                        'contents' => $validatedData['email']
                    ],

                    [
                        'name' => 'password',
                        'contents' => $validatedData['password']
                    ],
                    [
                        'name' => 'avatar',
                        'contents' => fopen($request->file('avatar'), 'r'),
                        'filename' => $request->file('avatar')->getClientOriginalName(),
                        'Mime-Type' => $request->file('avatar')->getmimeType()
                    ],
                ]
            ]);
        } else {

            $pResponse = $client->request('POST', "http://localhost:5000/api/admin/update", [
                'form_params' => $validatedData,
            ]);
        }

        if ($pResponse->getStatusCode() == 200) {
            $pBody = $pResponse->getBody()->getContents();
            $pData = json_decode($pBody, true);
            extract($pData);
            return redirect()->back()->with('toast_success', 'Update Succcess');
        } else {
            return redirect()->back()->with('error', 'Update Failed');
        }
    }
}
