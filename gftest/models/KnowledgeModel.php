<?php
namespace Models;
include_once('BaseModel.php');

class KnowledgeModel extends BaseModel {
	private $percent;
	
	public function __construct ($title, $percent) {
		parent::__construct($title);
		$this->setPercent($percent);
	}
	
	public function setPercent ($value) {
		$this->percent = htmlentities($value);
	}
	
	public function getPercent () {
		return $this->percent;
	}
	
	public function drawElement () {
		$knowledgeLine = '<li class="bar ' . strtolower($this->getTitle()) . '" style="height: ' . $this->getPercent() . '%" title="' . $this->getPercent() . '">';
		
		$knowledgeLine .= '<div class="percent">';
		$knowledgeLine .= $this->getPercent();
		$knowledgeLine .= '<span>%</span>';
		$knowledgeLine .= '</div>';
		
		$knowledgeLine .= '<div class="skill">' . $this->getTitle() . '</div>';
		
		$knowledgeLine .= '</li>';
		
		return $knowledgeLine;
	}
	
	public function drawForMobile () {
		$knowledgeLine = '<div class="knowlegdeLine" style="width: ' . $this->getPercent() . '%">' . $this->getTitle() . ': ' . $this->getPercent() . '%</div>';
		
		return $knowledgeLine;
	}
}