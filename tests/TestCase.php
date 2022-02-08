<?php

namespace Ibrodev\Crypto\Tests;

use Ibrodev\Crypto\ServiceSetupServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
  public function setUp(): void
  {
    parent::setUp();    
    // additional setup
  }

  protected function getPackageProviders($app)
  {
    return [
      ServiceSetupServiceProvider::class,
    ];
  }

  protected function getEnvironmentSetUp($app)
  {
    // perform environment setup
  }
}