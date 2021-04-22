<?php
namespace Guang\RuleEngine\Service;

use Neos\Flow\Annotations as Flow;
use JWadhams;

class RuleService {

    /**
     * @Flow\Inject
     * @var LogService
     */
    protected $logService;

    /**
     * @var int
     */
    protected $runCount = 0;

    /**
     * @var string
     */
    protected $lastOutput = '';

    /**
     * @var string
     */
    protected $originalData = '';

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
     * @param string $rules
     * @param string $data
     * @param bool $test
     * @param int $runs max times the rules should be applied
     * @param bool $singleRun
     * @return array|array[]|\array[][]|bool[]|\bool[][]|false[]|\false[][]|mixed|null[]|\null[][]|string[]|\string[][]
     * @throws \Exception
     */
    public function applyRules(string $rules, string $data, bool $test = false, int $runs = 0, bool $singleRun = false)
    {
        $this->runCount++;
        if ($this->runCount == 1) {
            $this->originalData = $data;
        }
        $this->logService->log('Applying Rules: Run #'.$this->runCount, ($test ? 'TEST' : 'INFO'), $data, $rules);
        $recursive = ($this->runCount > 1 ? false : true);
        $output = JWadhams\JsonLogic::apply(json_decode($rules), json_decode($data), true, $recursive, json_decode($this->originalData));

        if ($this->runCount > self::MAXRECURSIVE) {
            $this->logService->log("More than ".self::MAXRECURSIVE." recursive calls! Are you sure your rules do not contradict each other?", ($test ? 'TEST' : 'WARNING'), $data, $rules);
            throw new \Exception("More than ".self::MAXRECURSIVE." recursive calls! Are you sure your rules do not contradict each other?");
        }

        if (is_array(json_decode($rules)) && count(json_decode($rules)) == 1) {
            $singleRun = true;
        }

        if (($this->runCount < $runs || $runs == 0) && !$singleRun) {
            if ($this->lastOutput != $output) {
                $this->lastOutput = $output;
//                echo '<pre>'.var_export($this->lastOutput, true).'</pre>';
//                echo '<pre>'.var_export($output, true).'</pre>';
//                echo '<pre>'.var_export(json_encode($output), true).'</pre>';
//                echo '<pre>'.var_export($this->runCount, true).'</pre>';
//                echo '-----------------------------------------------';
                $output = $this->applyRules($rules, json_encode($output), $test, $runs);
            }
        }

        return $output;
    }

    public function getRuns()
    {
        return $this->runCount;
    }

}
