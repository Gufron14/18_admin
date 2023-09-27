<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $client = new Client(['headers' => [
            'Authorization' => 'Bearer ' . session('token')
        ]]);
        $pResponse = $client->request('GET', "http://localhost:5000/api/admin/package");
        $pBody = $pResponse->getBody()->getContents();
        $pData = json_decode($pBody, true);
        extract($pData);
        return view('dashboard.package.index', ['packages' => $pData['package']]);
    }

    public function store(Request $request)
    {

        $client = new Client(['headers' => [
            'Authorization' => 'Bearer ' . session('token')
        ]]);
        $validatedData = $request->validate([
            'package_name' => 'required|string',
            'count_month' => 'required|numeric',
            'price' => 'required|numeric',
        ]);
        $pResponse = $client->request('POST', "http://localhost:5000/api/admin/package", [
            'form_params' => $validatedData,
        ]);

        if ($pResponse->getStatusCode() == 200) {
            $pBody = $pResponse->getBody()->getContents();
            $pData = json_decode($pBody, true);
            extract($pData);
            return redirect()->back()->with('toast_success', 'Create Succcess');
        } else {
            return redirect()->back()->with('error', 'Update Failed');
        }
    }

    public function update(Request $request, $id)
    {
        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . session('token')
            ]
        ]);
        $validatedData = $request->validate([
            'package_name' => 'nullable|string',
            'count_month' => 'nullable|numeric',
            'price' => 'nullable|numeric',
        ]);

        $pResponse = $client->request('PUT', "http://localhost:5000/api/admin/package/$id", [
            'form_params' => $validatedData,
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
        $pResponse = $client->request('DELETE', "http://localhost:5000/api/admin/package/$request->id");
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
