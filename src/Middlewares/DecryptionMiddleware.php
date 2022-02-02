<?php

namespace Ibrodev\Servicesetup\Middlewares;

use Closure;
use Exception;
use Ibrodev\Servicesetup\Exceptions\DecryptionException;
use Ibrodev\Servicesetup\Exceptions\KeyNotFoundException;
use Ibrodev\Servicesetup\Helper;
use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\PublicKeyLoader;

class DecryptionMiddleware
{
    public function handle($request, Closure $next)
    {
        if(env("APP_ENVIRONMENT","TEST") != "LIVE") {
            $response = $next($request);

            return $response;
        }
        if(!$request->has("keys")) {
            throw new KeyNotFoundException("keys parameter is required");
        }

        if(!$request->has("data")) {
            throw new KeyNotFoundException("data is required in payload");
        }

        $privateKey = PublicKeyLoader::load(file_get_contents(Helper::get_file_path("private.key")));
         
        $decryptedKeys = json_decode($privateKey->decrypt( base64_decode($request->keys) ), true );

        $cipher = new AES('ctr');

        $iv = base64_decode($decryptedKeys["iv"]);

        $key = base64_decode($decryptedKeys["key"]);

        $cipher->setIV($iv);

        $cipher->setKey($key);

        try {
            $decryptedData = $cipher->decrypt(base64_decode($request->data));
        }catch(Exception $e) {
            throw new DecryptionException("Failed to decrypt data");
        }
     
     
        $request->replace(json_decode($decryptedData,true));

        $request->has("public_key");
      
        return $next($request);

    }
}