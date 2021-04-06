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
        $rule = '{
                    "modify": [
                        {"var":""},
                        "type",
                        "B"
                    ]
                }';
        $data = '[
                    {
                        "id": 1,
                        "class": "node",
                        "type": "A"
                    }
                ]';
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
        $rule = '{
                    "modify": [
                        {"var":""},
                        "new",
                        true
                    ]
                }';
        $data = '[
                    {
                        "id": 1,
                        "class": "node",
                        "type": "A"
                    }
                ]';
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
        $rule = '{
                    "modify": [
                        {"var":""},
                        "new"
                    ]
                }';
        $output = JsonLogic::apply(json_decode($rule), '');
    }

    /**
     * Test the removal of existing attribute
     *
     * @test
     */
    public function removeFunctionWithExistingAttribute()
    {
        $rule = '{
                    "remove": [
                        {"var":""},
                        "type"
                    ]
                }';
        $data = '[
                    {
                        "id": 1,
                        "class": "node",
                        "type": "A"
                    }
                ]';
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
        $rule = '{
                    "remove": [
                        {"var":""},
                        "new"
                    ]
                }';
        $data = '[
                    {
                        "id": 1,
                        "class": "node",
                        "type": "A"
                    }
                ]';
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
        $rule = '{
                    "remove": [
                        {"var":""}
                    ]
                }';
        $output = JsonLogic::apply(json_decode($rule),'');
    }

    /**
     * Test the cartesian function with two arrays
     *
     * @test
     */
    public function cartesianFunctionWithTwoArrays()
    {
        $rule = '{
                    "cartesian": [
                        {"var":""},
                        {"var":""}
                    ]
                }';
        $data = '[1,2]';
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
        $rule = '{
                    "cartesian": [
                        {"var":""}
                    ]
                }';
        $output = JsonLogic::apply(json_decode($rule), '');
    }
}
