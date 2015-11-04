<?php

namespace Adam\Bag;

class BagTest extends \PHPUnit_Framework_TestCase
{
    public function testGetWithSimpleValues()
    {
        $bag = new Bag(['foo' => 'bar', 4 => '15']);
        $this->assertEquals('bar', $bag->get('foo'));
        $this->assertEquals('15', $bag->get(4));
    }

    public function testGetReturnsDefaultOnUnset()
    {
        $bag = new Bag(['foo' => 'bar', 4 => '15']);
        $this->assertEquals(null, $bag->get('fizz'));
        $this->assertEquals(1, $bag->get('fizz', 1));
        $this->assertEquals('default!!', $bag->get('fizz', 'default!!'));
    }

    public function testSet()
    {
        $bag = new Bag(['foo' => 'bar', 4 => '15']);
        $bag->set('hello', 'world');
        $this->assertEquals('bar', $bag->get('foo'));
        $this->assertEquals('world', $bag->get('hello'));
    }

    public function testRemove()
    {
        $bag = new Bag(['foo' => 'bar', 'hello' => 'world']);
        $bag->remove('foo');
        $this->assertEquals(null, $bag->get('foo'));
        $this->assertEquals('world', $bag->get('hello'));
    }

    public function testGetSupportsDotNotationAccessToNestedArrays()
    {
        $bag = new Bag([
            'foo' => [
                'fizz' => 'buzz',
                7 => [
                    'hello' => 'world'
                ]
            ]
        ]);

        $this->assertEquals([
            'fizz' => 'buzz',
            7 => [
                'hello' => 'world'
            ]
        ], $bag->get('foo'));
        $this->assertEquals('world', $bag->get('foo.7.hello'));
    }

    public function testAll()
    {
        $bag = new Bag([
            'foo' => [
                'fizz' => 'buzz',
                7 => [
                    'hello' => 'world'
                ]
            ]
        ]);

        $this->assertEquals([
            'foo' => [
                'fizz' => 'buzz',
                7 => [
                    'hello' => 'world'
                ]
            ]
        ], $bag->all());
    }

    public function testFlush()
    {
        $bag = new Bag([
            'foo' => [
                'fizz' => 'buzz',
                7 => [
                    'hello' => 'world'
                ]
            ]
        ]);

        $bag->flush();

        $this->assertEquals([], $bag->all());
    }

    public function testPluck()
    {
        $bag = new Bag([
            'foo' => 'bar',
            'fizz' => 'buzz'
        ]);

        $this->assertEquals('buzz', $bag->pluck('fizz'));
        $this->assertEquals(null, $bag->get('fizz'));
        $this->assertEquals(1, count($bag->all()));
        $this->assertEquals('bar', $bag->get('foo'));
    }

    public function testArrayAccess()
    {
        $bag = new Bag();
        $bag['foo'] = 'bar';
        $this->assertTrue(isset($bag['foo']));
        $this->assertEquals('bar', $bag['foo']);
        $this->assertEquals('bar', $bag->get('foo'));
        unset($bag['foo']);
        $this->assertEquals(null, $bag->get('foo'));
        $this->assertFalse(isset($bag['foo']));
    }

    public function testJsonSerialize()
    {
        $bag = new Bag([
            'foo' => 'bar',
            'fizz' => 'buzz'
        ]);

        $json = json_encode($bag);
        $data = json_decode($json);

        $this->assertEquals('bar', $data->foo);
        $this->assertEquals('buzz', $data->fizz);
    }
}
