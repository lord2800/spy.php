<?php

class SpyTest extends \PHPUnit_Framework_TestCase {
	public function testCallIncrementsCount() {
		$spy = new \Spy\Spy([], []);
		$this->assertNotNull($spy);
	}
}
