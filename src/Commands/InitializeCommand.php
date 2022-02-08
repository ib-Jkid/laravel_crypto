<?php

namespace Ibrodev\Servicesetup\Commands;

use Ibrodev\Servicesetup\Helper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\RSA;

class InitializeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initialize:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up the basic services requirements for the core banking';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->info('Setting up services requirements');

        $privateKey = RSA::createKey();

        $publicKey = $privateKey->getPublicKey();

        file_put_contents(Helper::get_file_path("private.key"),$privateKey->toString("PKCS1"));

        $this->info('Generated Private Key');

        file_put_contents(Helper::get_file_path("public.key"),$publicKey->toString("PKCS1"));

        $this->info('Generated Public Key');
      
    }


   
}