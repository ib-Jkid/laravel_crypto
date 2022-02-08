<?php

namespace Ibrodev\Servicesetup\Tests;

use Ibrodev\Servicesetup\ServiceSetupServiceProvider;

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