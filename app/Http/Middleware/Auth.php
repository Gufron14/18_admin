<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class Auth
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
        if(session('token')){
            try{
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
            } catch ( Exception $e){
                session()->forget('token');
                return redirect('/login');
            }
        }
        return redirect('/login');
    }
}
