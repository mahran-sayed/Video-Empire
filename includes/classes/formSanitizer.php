<?php
class formSanitizer{
    public static function sanitizeFormString($input){
        $input = strip_tags($input);
        $input = str_replace(" ","",$input);
        $input = strtolower($input);
        $input = ucfirst($input);
        return $input;
    }
    public static function sanitizeFormUsername($input){
        $input = strip_tags($input);
        $input = str_replace(" ","",$input);
        $input = strtolower($input);
        return $input;
    }
    public static function sanitizeFormPassword($input){
        $input = strip_tags($input);
        return $input;
    }
    public static function sanitizeFormEmail($input){
        $input = strip_tags($input);
        $input = str_replace(" ","",$input);
        $input = strtolower($input);
        return $input;
    }
}

?>