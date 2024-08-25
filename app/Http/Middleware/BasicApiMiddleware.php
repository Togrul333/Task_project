<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // About Basic Auth
        // https://apipheny.io/basic-auth/#:~:text=Basic%20access%20authentication%20is%20a,when%20making%20an%20API%20request.&text=X%20should%20be%20replaced%20with,be%20replaced%20in%20this%20header.

        $data =  explode(" ", $request->header('Authorization'));

        if (count($data) != 2) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        if ($data[0] != "Basic") {
            return response()->json(['error' => 'Invalid method'], Response::HTTP_UNAUTHORIZED);
        }

        $val = base64_decode($data[1]);
        if ($val === false) {
            return response()->json(['error' => 'Invalid base64'], Response::HTTP_UNAUTHORIZED);
        }


        $arr = explode(":", $val);

        if (count($arr) != 2){
            return response()->json(['error' => 'Invalid token'], Response::HTTP_UNAUTHORIZED);
        }

        $username = $arr[0];
        $apikey = $arr[1];


        if (User::where('username', $username)->where('apikey',$apikey)->exists()){
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);

    }
}
