<?php
namespace Guang\RuleEngine\Service;

use Neos\Flow\Annotations as Flow;
use JWadhams;

class ApiService {

    /**
     * @var array
     */
    protected $errors = [];

    public function addError(string $key, string $message)
    {
        $this->errors['errors'][$key] = $message;
    }

    public function getErrorOutput()
    {
        return json_encode($this->errors);
    }

}
