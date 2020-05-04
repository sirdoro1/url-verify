<?php

namespace Sirdoro\UrlVerify\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class UrlVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(!file_exists('verified')){

            $client = new Client();

            $url = request()->fullUrl();

            $localserver = array('127.0.0.1','::1');
            
            try {
                
                if(!in_array($_SERVER['REMOTE_ADDR'], $localserver)){
                    $response = $client->request('GET',config('url-verify.api-url').'/?url='.$url);
                    
                    if($response->getStatusCode()=='200' && !in_array($_SERVER['REMOTE_ADDR'], $localserver)){
                        file_put_contents(public_path('verified'),now());
                    }
                }

            } catch (ClientException $ce) {}

        }
        
        return $next($request);
    }
}
