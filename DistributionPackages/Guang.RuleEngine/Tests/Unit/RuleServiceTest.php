<?php
namespace Guang\RuleEngine\Tests\Unit;

include_once('BaseTestCase.php');

use Guang\RuleEngine\Service\LogService;
use Guang\RuleEngine\Service\RuleService;


class RuleServiceTest extends BaseTestCase
{

    /**
     * @var RuleService
     */
    protected $ruleService;

    /**
     * @var LogService
     */
    protected $mockLogService;

    public function setUp(): void
    {
        $this->ruleService = new RuleService();
        $this->mockLogService = $this->getMockBuilder(LogService::class)->getMock();
        $this->inject($this->ruleService, 'logService', $this->mockLogService);
    }

    /**
     * Test applyRules function with one rule
     *
     * @test
     */
    public function applyRulesFunctionWithOneRule()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/applyRulesFunctionWithOneRule.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/applyRules.json');
        $expected = file_get_contents(dirname(__FILE__).'/Expectation/applyRulesFunctionWithOneRule.json');
        $output = $this->ruleService->applyRules($rule, $data, true);
        self::assertEquals($expected, json_encode($output));
    }

    /**
     * Test applyRules function with two rules
     *
     * @test
     */
    public function applyRulesFunctionWithTwoRules()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/applyRulesFunctionWithTwoRules.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/applyRules.json');
        $expected = file_get_contents(dirname(__FILE__).'/Expectation/applyRulesFunctionWithTwoRules.json');
        $output = $this->ruleService->applyRules($rule, $data, true);
        self::assertEquals($expected, json_encode($output));
    }

    /**
     * Test applyRules function with a rule that applies on the second run
     *
     * @test
     */
    public function applyRulesFunctionWithRecursiveRules()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/applyRulesFunctionWithRecursiveRules.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/applyRules.json');
        $expected = file_get_contents(dirname(__FILE__).'/Expectation/applyRulesFunctionWithRecursiveRules.json');
        $output = $this->ruleService->applyRules($rule, $data, true);
        self::assertEquals($expected, json_encode($output));
    }
}
