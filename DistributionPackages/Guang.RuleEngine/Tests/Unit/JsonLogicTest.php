<?php
namespace Guang\RuleEngine\Tests\Unit;

use JWadhams\JsonLogic;

class JsonLogicTest extends \PHPUnit\Framework\TestCase
{

    /**
     * Test the value change of an existing attribute
     *
     * @test
     */
    public function modifyFunctionWithExistingAttribute()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/modifyFunctionWithExistingAttribute.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/modifyFunctionWithExistingAttribute.json');
        $expected = '[{"id":1,"class":"node","type":"B"}]';
        $output = JsonLogic::apply(json_decode($rule), json_decode($data));
        self::assertEquals($expected, json_encode($output));
    }

    /**
     * Test the addition of a new attribute
     *
     * @test
     */
    public function modifyFunctionWithNewAttribute()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/modifyFunctionWithNewAttribute.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/modifyFunctionWithNewAttribute.json');
        $expected = '[{"id":1,"class":"node","type":"A","new":true}]';
        $output = JsonLogic::apply(json_decode($rule), json_decode($data));
        self::assertEquals($expected, json_encode($output));
    }

    /**
     * Test the function with unprovided params
     *
     * @test
     */
    public function modifyFunctionWithUnprovidedParams()
    {
        $this->expectException(\ArgumentCountError::class);
        $rule = file_get_contents(dirname(__FILE__).'/Rules/modifyFunctionWithUnprovidedParams.json');
        $output = JsonLogic::apply(json_decode($rule), '');
    }

    /**
     * Test the removal of existing attribute
     *
     * @test
     */
    public function removeFunctionWithExistingAttribute()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/removeFunctionWithExistingAttribute.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/removeFunctionWithExistingAttribute.json');
        $expected = '[{"id":1,"class":"node"}]';
        $output = JsonLogic::apply(json_decode($rule), json_decode($data));
        self::assertEquals($expected, json_encode($output));
    }

    /**
     * Test the remove function with non existing attribute
     *
     * @test
     */
    public function removeFunctionWithNonExistingAttribute()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/removeFunctionWithNonExistingAttribute.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/removeFunctionWithNonExistingAttribute.json');
        $expected = '[{"id":1,"class":"node","type":"A"}]';
        $output = JsonLogic::apply(json_decode($rule), json_decode($data));
        self::assertEquals($expected, json_encode($output));
    }

    /**
     * Test the function with unprovided params
     *
     * @test
     */
    public function removeFunctionWithUnprovidedParams()
    {
        $this->expectException(\ArgumentCountError::class);
        $rule = file_get_contents(dirname(__FILE__).'/Rules/removeFunctionWithUnprovidedParams.json');
        $output = JsonLogic::apply(json_decode($rule),'');
    }

    /**
     * Test the cartesian function with two arrays
     *
     * @test
     */
    public function cartesianFunctionWithTwoArrays()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/cartesianFunctionWithTwoArrays.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/cartesianFunctionWithTwoArrays.json');
        $expected = '[[1,1],[1,2],[2,1],[2,2]]';
        $output = JsonLogic::apply(json_decode($rule), json_decode($data));
        self::assertEquals($expected, json_encode($output));
    }

    /**
     * Test the function with unprovided params
     *
     * @test
     */
    public function cartesianFunctionWithUnprovidedParams()
    {
        $this->expectException(\ArgumentCountError::class);
        $rule = file_get_contents(dirname(__FILE__).'/Rules/cartesianFunctionWithUnprovidedParams.json');
        $output = JsonLogic::apply(json_decode($rule), '');
    }

    /**
     * Test the function with an object
     *
     * @test
     */
    public function groupFunctionNormal()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/groupFunctionNormal.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/groupFunctionNormal.json');
        $expected = '{"Group A":[{"id":1,"class":"node","type":"A"}]}';
        $output = JsonLogic::apply(json_decode($rule), json_decode($data), false, true, json_decode($data));
        self::assertEquals($expected, json_encode($output));
    }

    /**
     * Test the function with a filter
     *
     * @test
     */
    public function groupFunctionWithFilter()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/groupFunctionWithFilter.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/groupFunctionWithFilter.json');
        $expected = '{"Group A":[{"id":1,"class":"node","type":"A"}]}';
        $output = JsonLogic::apply(json_decode($rule), json_decode($data), false, true, json_decode($data));
        self::assertEquals($expected, json_encode($output));
    }

    /**
     * Test the function with list of numbers
     *
     * @test
     */
    public function groupFunctionWithNumbers()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/groupFunctionNormal.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/groupFunctionWithNumbers.json');
        $expected = '{"Group A":[1,2]}';
        $output = JsonLogic::apply(json_decode($rule), json_decode($data), false, true, json_decode($data));
        self::assertEquals($expected, json_encode($output));
    }

    /**
     * Test the function with number
     *
     * @test
     */
    public function sqrtFunctionNumbers()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/sqrtFunctionNumbers.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/sqrtFunctionNumbers.json');
        $expected = '2';
        $output = JsonLogic::apply(json_decode($rule), json_decode($data), false, true, json_decode($data));
        self::assertEquals($expected, json_encode($output));
    }

    /**
     * Test the function with number from data
     *
     * @test
     */
    public function sqrtFunctionNumbersFromData()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/sqrtFunctionNumbersFromData.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/sqrtFunctionNumbersFromData.json');
        $expected = '2';
        $output = JsonLogic::apply(json_decode($rule), json_decode($data), false, true, json_decode($data));
        self::assertEquals($expected, json_encode($output));
    }

    /**
     * @test
     */
    public function createFunctionWithEmptyData()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/createFunctionWithEmptyData.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/createFunctionWithEmptyData.json');
        $expected = '[{"Attribute1":"value1","Attribute2":"value2"}]';
        $output = JsonLogic::apply(json_decode($rule), json_decode($data), false, true, json_decode($data));
        self::assertEquals($expected, json_encode($output));
    }

    /**
     * @test
     */
    public function createFunctionWithData()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/createFunctionWithData.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/createFunctionWithData.json');
        $expected = '[{"id":1,"class":"node","type":"A"},{"Attribute1":"value1","Attribute2":"value2"}]';
        $output = JsonLogic::apply(json_decode($rule), json_decode($data), false, true, json_decode($data));
        self::assertEquals($expected, json_encode($output));
    }

    /**
     * @test
     */
    public function createFunctionWithSameData()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/createFunctionWithSameData.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/createFunctionWithSameData.json');
        $expected = '[{"id":1,"class":"node","type":"A"},{"id":1,"class":"node","type":"A"}]';
        $output = JsonLogic::apply(json_decode($rule), json_decode($data), false, true, json_decode($data));
        self::assertEquals($expected, json_encode($output));
    }

    /**
     * @test
     */
    public function joinFunctionWithTwoGroups()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/joinFunctionWithTwoGroups.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/applyRules.json');
        $expected = '[[{"Group A":[{"id":1,"class":"node","type":"A"}]},{"Group B":[{"id":2,"class":"node","type":"B"},{"id":3,"class":"node","type":"B"},{"id":4,"class":"edge","type":"B"}]}]]';
        $output = JsonLogic::apply(json_decode($rule), json_decode($data), false, true, json_decode($data));
        self::assertEquals($expected, json_encode($output));
    }

    /**
     * @test
     */
    public function joinFunctionWithTwoData()
    {
        $rule = file_get_contents(dirname(__FILE__).'/Rules/joinFunctionWithTwoData.json');
        $data = file_get_contents(dirname(__FILE__).'/Data/joinFunctionWithTwoData.json');
        $expected = '[{"id":1,"class":"node","type":"A"},{"id":1,"class":"node","type":"A"}]';
        $output = JsonLogic::apply(json_decode($rule), json_decode($data), false, true, json_decode($data));
        self::assertEquals($expected, json_encode($output));
    }
}
