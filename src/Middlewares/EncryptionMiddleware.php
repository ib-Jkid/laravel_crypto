<?php

namespace Ibrodev\Servicesetup\Middlewares;

use Closure;
use Ibrodev\Servicesetup\Exceptions\KeyNotFoundException;
use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\Random;

class EncryptionMiddleware
{
    public function handle($request, Closure $next)
    {  
        $cipher = new AES('ctr');

        $iv = Random::string(16);
        $key = Random::string(16);

        $cipher->setIV($iv);
        $cipher->setKey($key);

        

        $ciphertext = $cipher->encrypt( json_encode($request->all()) );
        

        $keys = [
            "iv" => base64_encode($iv),
            "key" => base64_encode($key)
        ];



        if(!$request->has("public_key") ) {
            throw new KeyNotFoundException("Public key was not passed in the request");
        }

        $reciever_public_key = $request->public_key;

        $publicKey = PublicKeyLoader::load( $reciever_public_key );

     

     
      
        $cipherkey = $publicKey->encrypt( json_encode($keys) );

      
     

        $request->replace(["data" => base64_encode($ciphertext), "keys" => base64_encode($cipherkey) ]);

      

        $response = $next($request);

    


        return $response;
    }
}