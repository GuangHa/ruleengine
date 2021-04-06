<?php
namespace Guang\RuleEngine\Service;

use Neos\Flow\Annotations as Flow;

class RuleService {

    public function checkInput(string $input) {

        if ($input == '') {
            return 'Input cannot be blank';
        } else {
            $data = json_decode($input);
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    return false;
                case JSON_ERROR_DEPTH:
                    return 'Maximum stack depth exceeded';
                case JSON_ERROR_STATE_MISMATCH:
                    return 'Underflow or the modes mismatch';
                case JSON_ERROR_CTRL_CHAR:
                    return 'Unexpected control character found';
                case JSON_ERROR_SYNTAX:
                    return 'Syntax error, malformed JSON';
                case JSON_ERROR_UTF8:
                    return 'Malformed UTF-8 characters, possibly incorrectly encoded';
                default:
                    return 'Unknown error';
            }
        }
    }

}
