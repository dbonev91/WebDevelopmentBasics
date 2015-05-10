<?php
namespace Models;
include_once('BaseModel.php');

class CertificateModel extends \Models\BaseModel {
	private $href;
	
	public function __construct ($title, $href) {
		parent::__construct($title);
		$this->setHref($href);
	}
	
	public function setHref ($value) {
		$this->href = htmlentities($value);
	}
	
	public function getHref () {
		return $this->href;
	}
	
	public function drawElement () {
		$certificate = '<li><a target="_tab" href="' . $this->getHref() . '">' . $this->getTitle() . '</a></li>';
		
		return $certificate;
	}
}