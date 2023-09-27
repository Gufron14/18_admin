<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = new Client(['headers' => [
            'Authorization' => 'Bearer ' . session('token')
        ]]);
        $cResponse = $client->request('GET', "http://localhost:5000/api/admin/user");
        $cBody = $cResponse->getBody()->getContents();
        $cData = json_decode($cBody, true);
        extract($cData);
        //dd($cResponse);
        //return response()->json('BISA LO');
        return view('dashboard.customer.index', $cData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . session('token')
            ]
        ]);
        // dd($id);
        $validatedData = $request->validate([
            'username' => 'nullable|string|max:255',
            'email' => 'nullable|email:rfc,dns',
            'status' => 'nullable|in:0,1', // assuming array type for coordinate
            'role' => 'nullable|in:0,1',
            'avatar' => 'nullable|mimes:png,jpg,jpeg',
        ]);
        if ($request->file('avatar')) {
            $pResponse = $client->request('PUT', "http://localhost:5000/api/admin/user/$id", [
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
                        'name' => 'status',
                        'contents' => $validatedData['status']
                    ],
                    [
                        'name' => 'role',
                        'contents' => $validatedData['role']
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

            $pResponse = $client->request('PUT', "http://localhost:5000/api/admin/user/$id", [
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // dd($request);
        $client = new Client(['headers' => [
            'Authorization' => 'Bearer ' . session('token')
        ]]);
        $cResponse = $client->request('DELETE', "http://localhost:5000/api/admin/user/$request->id");
        if ($cResponse->getStatusCode() == 200) {
            $pBody = $cResponse->getBody()->getContents();
            $pData = json_decode($pBody, true);
            extract($pData);
            return redirect()->back()->with('toast_success', 'Update Succcess');
        } else {
            return redirect()->back()->with('error', 'Update Failed');
        }
    }
}
