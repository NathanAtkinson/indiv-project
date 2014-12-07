<?php

class Util {

    public static function zip($keys, $input) {
        $zipped = [];
        // only accept the required keys into array
        // when not all required keys given throw error
        foreach ($keys as $key) {
            if (isset($input[$key])) $zipped[$key] = $input[$key];
            else throw new Exception('Not all keys assigned! '.$key);
        }
        // quote values
        return $zipped;
    }

}

