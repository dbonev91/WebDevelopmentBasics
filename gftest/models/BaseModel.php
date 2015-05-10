<?php
namespace Models;

abstract class BaseModel {
	private $title;
	protected $dirPrefix = '/gftest/public/';
	
	public function __construct ($title) {
		$this->setTitle($title);
	}
	
	public function setTitle ($value) {
		$this->title = htmlentities($value);
	}
	
	public function getTitle () {
		return $this->title;
	}
	
	public abstract function drawElement ();
}