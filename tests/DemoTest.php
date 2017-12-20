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
        $redis = new \Predis\Client();
        $redis->set('foo', 'bar');
        $this->assertEquals('bar', $redis->get('foo'));
    }
}