<?php

trait Validation {

    // make function `filter_var` return 
    // null instead of false on fail
    private function addNullFlag($validator) {
        if (@$validator[1]) {
            $validator[1]['flags'] = FILTER_NULL_ON_FAILURE;
            return $validator;
        }
        $validator[] = ['flags' => FILTER_NULL_ON_FAILURE];
    }

    // validate input for all input fields provided, 
    // return only values in class, others will be dropped
    public function validate($input) {

        // List of validatiors
        $validators = $this->validators();
        $validated = [];
        foreach ($input as $key => $value) {

            // skip key if not in list of validators
            if ($validators[$key] === null) continue;

            // if boolean is validated I don't want
            // false return so return null for all failures
            $validateWithNullFlag = 
                $this->addNullFlag($validators[$key]);

            // use filter_var function 
            $isValid = call_user_func_array(
                'filter_var', array_merge([$value], $validators[$key]));

            // return name of failed key if it didn't pass
            // "fail early, fail fast"
            if ($isValid === null) {
                return ['failed' => $key];
            }

            // if successful add to validated array
            $validated[$key] = $isValid;
        }
        return $validated;
    }

}
