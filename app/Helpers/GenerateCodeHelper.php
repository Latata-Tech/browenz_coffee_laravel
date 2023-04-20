<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

class GenerateCodeHelper {
    public static function generateCode(string $prefix, $model) {
        $lastCode = $model::orderBy('id','desc')->first();
        if(is_null($lastCode)) {
            $numToStr = sprintf("%04d", 1);
            return "$prefix-$numToStr";
        }
        $lastCode = (int)explode('-', $lastCode->code)[1];
        $numToStr = sprintf("%04d", ++$lastCode);
        return "$prefix-$numToStr";
    }
}
