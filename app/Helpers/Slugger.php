<?php
namespace App\Helpers;
Class Slugger{

    public static function slugit($slug){
        if(strlen($slug)>20){
            $trim = -1 * abs(strlen($slug));
            $slug = substr($slug,$trim,10);            
        }
        $slug = str_replace(" ",'-',$slug);
        return strtolower($slug);
    }

}