<?php
namespace Guang\RuleEngine\Service;

use Neos\Flow\Annotations as Flow;
use JWadhams;

class RuleService {

    /**
     * @var int
     */
    protected $runCount = 0;

    /**
     * @var string
     */
    protected $lastOutput = '';

    const MAXRECURSIVE = 100;

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

    /**
     * @param string $data
     * @param string $rules
     * @param int $runs         max times the rules should be applied
     * @return array|array[]|\array[][]|bool[]|\bool[][]|false[]|\false[][]|mixed|null[]|\null[][]|string[]|\string[][]
     * @throws \Exception
     */
    public function applyRules(string $rules, string $data, int $runs = 0)
    {
        $this->runCount++;
        $output = JWadhams\JsonLogic::apply(json_decode($rules), json_decode($data), true);

        if ($this->runCount > self::MAXRECURSIVE) {
            throw new \Exception("More than ".self::MAXRECURSIVE." recursive calls! Are you sure your rules do not contradict each other?");
        }

        if ($this->runCount < $runs || $runs == 0) {
            if ($this->lastOutput != $output) {
                $this->lastOutput = $output;
                $output = $this->applyRules($rules, json_encode($output), $runs);
            }
        }

        return $output;
    }

    public function getRuns()
    {
        return $this->runCount;
    }

}
