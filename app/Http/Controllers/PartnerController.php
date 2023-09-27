<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;


class PartnerController extends Controller
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
        $pResponse = $client->request('GET', "http://localhost:5000/api/admin/partner");
        $pBody = $pResponse->getBody()->getContents();
        $pData = json_decode($pBody, true);
        extract($pData);

        return view('dashboard.partner.index', ['partners' => $pData['partner']]);
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
        $client = new Client(['headers' => [
            'Authorization' => 'Bearer ' . session('token')
        ]]);
        $pResponse = $client->request('GET', "http://localhost:5000/api/admin/partner/$id");
        $pBody = $pResponse->getBody()->getContents();
        $pData = json_decode($pBody, true);
        extract($pData);
        // dd($pData['partner']);
        return view('dashboard.partner.detail', ['partner' => $pData['partner']]);
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
        $validatedData = $request->validate([
            'partner_name' => 'nullable|string',
            'email' => 'nullable|email:rfc,dns',
            'coordinate' => 'nullable', // assuming array type for coordinate
            'count_order' => 'nullable|integer|min:0',
            'account_status' => 'nullable|in:0,1', // assuming account status can only be 1, 2 or 3
            'operational_status' => 'nullable|in:0,1', // assuming operational status can only be 1 or 2
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'avatar' => 'nullable|mimes:png,jpg,jpeg',
        ]);
        if($request->file('avatar')){
            $pResponse = $client->request('POST', "http://localhost:5000/api/admin/partner/update/$id", ['multipart' => [
                [
                    'name'=>'partner_name',
                    'contents'=>$validatedData['partner_name']
                ],
    
                [
                    'name'=>'email',
                    'contents'=>$validatedData['email']
                ],
    
                [
                    'name'=>'phone_number',
                    'contents'=>$validatedData['phone_number']
                ],
    
                [
                    'name' => 'avatar',
                    'contents' => fopen( $request->file('avatar'), 'r' ),
                    'filename' => $request->file('avatar')->getClientOriginalName(),
                    'Mime-Type' => $request->file('avatar')->getmimeType()
                ],
    
                [
                    'name'=>'address',
                    'contents'=>$validatedData['address']
                ],
    
                [
                    'name'=>'description',
                    'contents'=>$validatedData['description']
                ],
    
                [
                    'name'=>'count_order',
                    'contents'=>$validatedData['count_order']
                ],
                [
                    'name'=>'account_status',
                    'contents'=>$validatedData['account_status']
                ],
                [
                    'name'=>'operational_status',
                    'contents'=>$validatedData['operational_status']
                ],
            ]]);
        } else {
            $pResponse = $client->request('POST', "http://localhost:5000/api/admin/partner/update/$id", ['multipart' => [
                [
                    'name'=>'partner_name',
                    'contents'=>$validatedData['partner_name']
                ],
    
                [
                    'name'=>'email',
                    'contents'=>$validatedData['email']
                ],
    
                [
                    'name'=>'phone_number',
                    'contents'=>$validatedData['phone_number']
                ],
                [
                    'name'=>'address',
                    'contents'=>$validatedData['address']
                ],
    
                [
                    'name'=>'description',
                    'contents'=>$validatedData['description']
                ],
    
                [
                    'name'=>'count_order',
                    'contents'=>$validatedData['count_order']
                ],
                [
                    'name'=>'account_status',
                    'contents'=>$validatedData['account_status']
                ],
                [
                    'name'=>'operational_status',
                    'contents'=>$validatedData['operational_status']
                ],
            ]]);
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

    public function confirmation($id, $account_status)
    {
        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . session('token')
            ]
        ]);
        $request_status = ['request_status' => $account_status];
        // dd($status);

        $pResponse = $client->request('PUT', "http://localhost:5000/api/admin/partner/$id/confirmation", [
            'form_params' => $request_status,
        ]);

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
        $client = new Client(['headers' => [
            'Authorization' => 'Bearer ' . session('token')
        ]]);
        $pResponse = $client->request('POST', "http://localhost:5000/api/admin/partner/$request->id");
        if ($pResponse->getStatusCode() == 200) {
            $pBody = $pResponse->getBody()->getContents();
            $pData = json_decode($pBody, true);
            extract($pData);
            return redirect('dashboard/partner')->with('toast_success', 'Delete Succcess');
        } else {
            return redirect()->back()->with('error', 'Delete failed');
        }
    }
}
