<?php

namespace Ibrodev\Servicesetup\Middlewares;

use Closure;
use Ibrodev\Servicesetup\Exceptions\DecryptionException;
use Ibrodev\Servicesetup\Exceptions\InvalidRequestException;
use Ibrodev\Servicesetup\Exceptions\KeyNotFoundException;
use Ibrodev\Servicesetup\Helper;
use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\PublicKeyLoader;

class DecryptionMiddleware
{
    public function handle($request, Closure $next)
    {
       
     

        $privateKey = PublicKeyLoader::load(  file_get_contents(Helper::get_file_path("private.key") ) );


        $decryptedKeys = json_decode($privateKey->decrypt( base64_decode($request->keys) ), true );

        

      


        $cipher = new AES('ctr');

        $iv = base64_decode($decryptedKeys["iv"]);
        $key = base64_decode($decryptedKeys["key"]);

        $cipher->setIV($iv);
        $cipher->setKey($key);

        $decryptedData = $cipher->decrypt(base64_decode($request->data));
        
        $request->replace(json_decode($decryptedData,true));

        $request->has("public_key");
      
    
        return $next($request);

    }
}