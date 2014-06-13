<?php
namespace Spy;

class Spy {
	private $data;
	private $returns;

	// TODO interface to read these--maybe reflection?
	private $count = 0;
	private $args = array();
	private $calls = array();
	private $gets = array();
	private $sets = array();

	// TODO better fluent interface--but how?
	public function __construct($data, $returns) { $this->data = $data; $this->returns = $returns; }

	public function __invoke() {
		$this->count++;
		$this->args[] = func_get_args();
		return $this->returns['__invoke'];
	}

	public function __call($name, $args) {
		if(!key_exists($this->calls[$name])) {
			$this->calls[$name] = [ 'count' => 0, 'args' => [] ];
		}
		$this->calls[$name]['count']++;
		$this->calls[$name]['args'][] = $args;
		return $this->returns[$name];
	}

	public function __get($prop) {
		if(!key_exists($prop, $this->data)) {
			throw new \RuntimeException('Misconfigured spy! Tried to get ' . $prop . ' but it didn\'t exist.');
		}
		$this->gets[$prop] = key_exists($this->gets, $prop) ? 0 : $this->gets[$prop] + 1;
		return $this->data[$prop];
	}
	public function __set($prop, $val) {
		if(!key_exists($prop, $this->data)) {
			throw new \RuntimeException('Misconfigured spy! Tried to set ' . $prop . ' but it didn\'t exist.');
		}
		$this->sets[$prop] = key_exists($this->sets, $prop) ? 0 : $this->sets[$prop] + 1;
		$this->data[$prop] = $val;
	}
}
