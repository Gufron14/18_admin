<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SquareFeedController extends Controller
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
        $pResponse = $client->request('GET', "http://localhost:5000/api/admin/sq");
        $pBody = $pResponse->getBody()->getContents();
        $pData = json_decode($pBody, true);
        extract($pData);

        return view('dashboard.squarefeed.index', ['squarefeeds' => $pData['squarefeed']]);
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
        // dd($request);
        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . session('token')
            ]
        ]);
        $validatedData = $request->validate([
            'img_path' => 'nullable|mimes:png,jpg,jpeg',
        ]);

        $pResponse = $client->request('POST', "http://localhost:5000/api/admin/sq", [
            'multipart' => [
                [
                    'name' => 'image',
                    'contents' => fopen( $request->file('img_path'), 'r' ),
                    'filename' => $request->file('img_path')->getClientOriginalName(),
                    'Mime-Type' => $request->file('img_path')->getmimeType()
                ]
            ]
        ]);

        if ($pResponse->getStatusCode() == 200) {
            $pBody = $pResponse->getBody()->getContents();
            $pData = json_decode($pBody, true);
            extract($pData);
            return redirect()->back()->with('toast_success', 'Create Succcess');
        } else {
            return redirect()->back()->with('error', 'Create Failed');
        }
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
        $validatedData = $request->validate([
            'img_path' => 'nullable|mimes:png,jpg,jpeg',
        ]);

        $pResponse = $client->request('POST', "http://localhost:5000/api/admin/sq/$id", [
            'multipart' => [
                [
                    'name' => 'image',
                    'contents' => fopen( $request->file('img_path'), 'r' ),
                    'filename' => $request->file('img_path')->getClientOriginalName(),
                    'Mime-Type' => $request->file('img_path')->getmimeType()
                ]
            ]
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
        $pResponse = $client->request('DELETE', "http://localhost:5000/api/admin/sq/$request->id");
        if ($pResponse->getStatusCode() == 200) {
            $pBody = $pResponse->getBody()->getContents();
            $pData = json_decode($pBody, true);
            extract($pData);
            return redirect()->back()->with('toast_success', 'Delete Succcess');
        } else {
            return redirect()->back()->with('error', 'Delete failed');
        }
    }
}
