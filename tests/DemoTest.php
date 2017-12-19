<?php
class DemoTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function hello()
    {
        $this->assertEquals(1, 1);
    }

    /** @test */
    public function redis()
    {
        $redis = new Redis();
        $redis->connect('localhost');
        $redis->set('foo', 'bar');
        $this->assertEquals('bar', $redis->get('foo'));
    }
}