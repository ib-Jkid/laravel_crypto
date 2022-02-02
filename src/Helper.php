<?php

namespace Ibrodev\Servicesetup;

use Illuminate\Support\Facades\App;

class Helper {
    public static function get_file_path($fileName) {

        $isTest = App::runningUnitTests();

        return ($isTest)? __DIR__. "\\..\\..\\{$fileName}" : base_path($fileName);
        
    }
}