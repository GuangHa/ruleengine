<?php
namespace Guang\RuleEngine\Tests\Unit;

use Neos\Flow\Annotations as Flow;
use Guang\RuleEngine\Service\RuleService;

class RuleServiceTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @Flow\Inject
     * @var RuleService
     */
    protected $ruleService;

    /**
     * Test applyRules function with one rule
     *
     * @test
     */
//    public function applyRulesFunctionWithOneRule()
//    {
//        $rule = file_get_contents(dirname(__FILE__).'/Rules/applyRulesFunctionWithOneRule.json');
//        $data = file_get_contents(dirname(__FILE__).'/Data/applyRules.json');
//        $expected = '[{"id":1,"class":"node","type":"B"}]';
//        $output = $this->ruleService->applyRules($rule, $data, true);
//        var_dump($output);
//        self::assertEquals($expected, json_encode($output));
//    }

//    /**
//     * Test applyRules function with two rules
//     *
//     * @test
//     */
//    public function applyRulesFunctionWithTwoRules()
//    {
//        $rule = file_get_contents(dirname(__FILE__).'/Rules/applyRulesFunctionWithTwoRules.json');
//        $data = file_get_contents(dirname(__FILE__).'/Data/applyRules.json');
//        $expected = '[{"id":1,"class":"node","type":"B"}]';
//        $output = $this->ruleService->applyRules($rule, $data, true);
//        self::assertEquals($expected, json_encode($output));
//    }
//
//    /**
//     * Test applyRules function with a rule that applies on the second run
//     *
//     * @test
//     */
//    public function applyRulesFunctionWithRecursiveRules()
//    {
//        $rule = file_get_contents(dirname(__FILE__).'/Rules/applyRulesFunctionWithRecursiveRules.json');
//        $data = file_get_contents(dirname(__FILE__).'/Data/applyRules.json');
//        $expected = '[{"id":1,"class":"node","type":"B"}]';
//        $output = $this->ruleService->applyRules($rule, $data, true);
//        self::assertEquals($expected, json_encode($output));
//    }
}
