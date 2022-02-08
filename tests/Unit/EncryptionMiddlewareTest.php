<?php

namespace Ibrodev\Crypto\Tests\Unit;

use Ibrodev\Crypto\Helper;
use Ibrodev\Crypto\Middlewares\DecryptionMiddleware;
use Ibrodev\Crypto\Middlewares\EncryptionMiddleware;
use Illuminate\Http\Request;
use Ibrodev\Crypto\Tests\TestCase;


class EncryptionMiddlewareTest extends TestCase
{

    function test_keys_create() {

        if(file_exists(Helper::get_file_path("private.key"))) {
            unlink(Helper::get_file_path("private.key"));
        }

        
        if(file_exists(Helper::get_file_path("public.key"))) {
            unlink(Helper::get_file_path("public.key"));
        }
       
        $this->artisan('crypto:init')->assertSuccessful();

        $this->assertFileExists(Helper::get_file_path("private.key"));
        $this->assertFileExists(Helper::get_file_path("public.key"));

    }
   
    function test_encription_and_decryption()
    {
        $baseRequest = new Request();

        $baseRequest->merge([
            'title' => 'some title',
            "status" => true,
            'title1' => 'some title',
            'title2' => 'some title','title3' => 'some title','title4' => 'some title','title5' => 'some title','title6' => 'some title',
            "public_key" =>  file_get_contents(  Helper::get_file_path("public.key") ) ]);

  
        $response =  (new EncryptionMiddleware())->handle($baseRequest, function ($request) use($baseRequest) {
            
            (new DecryptionMiddleware())->handle($request, function ($request) use($baseRequest) {
                $this->assertEquals($request->title,$baseRequest->title);
                $this->assertTrue($request->has("title"));
                $this->assertTrue($request->has("status"));
                $this->assertEquals($request->status, $baseRequest->status);
                $this->assertTrue($request->has("public_key"));
            });

         
        });


      
    }
}