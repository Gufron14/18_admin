<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DefaultVariableMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $client = new Client(['headers' => [
            'Authorization' => 'Bearer ' . session('token')
        ]]);
        $pResponse = $client->request('GET', "http://localhost:5000/api/admin/me");
        $pBody = $pResponse->getBody()->getContents();
        $pData = json_decode($pBody, true);
        extract($pData);

        // Set the default variable here
        $userLogin = $pData['admin'];

        // Pass the default variable to all views
        view()->share('userLogin', $userLogin);

        return $next($request);
    }
}
