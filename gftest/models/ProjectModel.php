<?php
namespace Models;
include_once('BaseModel.php');

class ProjectModel extends \Models\BaseModel {
	private $content;
	private $image;
	private $type;
	private $github = null;
	private $demo = null;
	
	public function __construct ($title, $content, $image, $type, $github = null, $demo = null) {
		parent::__construct($title);
		$this->setContent($content);
		$this->setImage($image);
		$this->setGithub($github);
		$this->setDemo($demo);
		$this->setType($type);
	}
	
	public function setContent ($value) {
		$this->content = htmlentities($value);
	}
	
	public function getContent () {
		return $this->content;
	}
	
	public function setImage ($value) {
		$this->image = htmlentities($value);
	}
	
	public function getImage () {
		return $this->image;
	}
	
	public function setType ($value) {
		$this->type = htmlentities($value);
	}
	
	public function getType () {
		return $this->type;
	}
	
	public function setGithub ($value = null) {
		if ($value) {
			$this->github = htmlentities($value);
		}
	}
	
	public function getGithub () {
		return $this->github;
	}
	
	public function setDemo ($value = null) {
		if ($value) {
			$this->demo = htmlentities($value);
		}
	}
	
	public function getDemo () {
		return $this->demo;
	}
	
	public function drawElement () {
        $outputProject = '<div class="project-item">';
        $outputProject .= '<img class="imageshow" src="' . $this->dirPrefix . 'img/projects/thumbs/' . $this->getImage() . '.jpg" alt="" />';
        $outputProject .= '<div class="projectInfo">';
        $outputProject .= '<span class="typeofWork">' . $this->createType($this->getType()) . '</span>';
        $outputProject .= '<h4 class="projectName">' . $this->getTitle() . '</h4>';
        $outputProject .= '</div>';
        $outputProject .= '<a class="seemore" href="#" data-toggle="modal" data-target="#myModal1"><img src="' . $this->dirPrefix . 'img/seemore.png" alt=""></a>';
        $outputProject .= $this->demoLink($this->getDemo());
		$outputProject .= $this->githubLink($this->getGithub());
        $outputProject .= '</div>';
        
        return $outputProject;
	}
	
	public function createType ($type) {
		switch ($type) {
			case "SoftUni";
				return "SoftUni Project";
			case "Private";
				return "Private Project";
			default:
				return null;
		}
	}
	
	public function demoLink ($demo) {
		if ($demo) {
			$demoLink = '<a target="_tab" class="link" href="' . $demo . '"><img src="' . $this->dirPrefix . 'img/link.png" alt=""></a>';
		}
		else {
			$demoLink = null;
		}
		
		return $demoLink;
	}
	
	public function githubLink ($github) {
		if ($github) {
			$githubLink = '<a target="_tab" class="githubLink" href="' . $github . '"><img src="' . $this->dirPrefix . 'img/github.png" alt=""></a>';
		}
		else {
			$githubLink = null;
		}
		
		return $githubLink;
	}
}