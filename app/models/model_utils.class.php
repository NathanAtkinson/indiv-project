<?php

/*
* Utilized w/ validation...only uses items needed
*/

trait ModelUtils {

    use Validation;

    protected function cleanInput($requiredInput, $input, $noQuote = []) {
        $boundedValues = Util::zip($requiredInput, $input);
        $validatedValues = $this->validate($boundedValues);
        if (array_key_exists('failed', $validatedValues)) {
            return 'The required key "'. $validatedValues['failed'] . '" was not provided!';
        }
        return db::auto_quote($validatedValues, $noQuote);
    }

}
