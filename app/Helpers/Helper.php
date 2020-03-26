<?php
namespace App\Helpers;

class Helper {
    public static function navigation_selected ($navigation) {
        return request()->route()->getName() === $navigation ? 'active' : '';
    }
}