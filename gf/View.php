<?php
	
namespace GF;

class View {
	private static $_instance = null;
	private $___viewPath = null;
	private $___data = array();
	private $___viewDir = null;
	private $___extension = '.php';
	private $___layoutParts = array();
	private $___layoutData = array();
	
	private function __construct() {
		$this->___viewPath = \GF\App::getInstance()->getConfig()->app['viewsDirecotry'];
		
		if ($this->___viewPath == null) {
			$this->___viewPath = realpath('../views/');
		}
	}
	
	public function setViewDirectory($path) {
		$path = trim($path);
		
		if ($path) {
			$path = realpath($path) . DIRECTORY_SEPARATOR;
			
			if (is_dir($path) && is_readable($path)) {
				$this->___viewDir = $path;
			}
			else {
				throw new \Exception('View path', 500);
			}
		}
		else {
			throw new \Exception('View path', 500);
		}
	}
	
	public function display($name, $data = array(), $returnAsString = false) {
		if (is_array($data)) {
			$this->___data = array_merge($this->___data, $data);
		}
		
		if (count($this->___layoutParts) > 0) {
			foreach ($this->___layoutParts as $layoutKey => $layoutValue) {
				$currentLayout = $this->_includeFile($layoutValue);
				
				if ($currentLayout) {
					$this->___layoutData[$layoutKey] = $currentLayout;
				}
			}
		}
		
		if ($returnAsString) {
			return $this->_includeFile($name);
		}
		else {
			echo $this->_includeFile($name);
		}
	}
	
	public function getLayoutData($name) {
		return $this->___layoutData[$name];
	}
	
	public function appendToLayout($key, $template) {
		if ($key && $template) {
			$this->___layoutParts[$key] = $template;
		}
		else {
			throw new \Exception('Layout require valid key and template', 500);
		}
	}
	
	private function _includeFile($file) {
		if ($this->___viewDir == null) {
			$this->setViewDirectory($this->___viewPath);
		}
		
		$___fullPathToFile = $this->___viewDir . str_replace('.', DIRECTORY_SEPARATOR, $file) . $this->___extension;
		
		if (file_exists($___fullPathToFile) && is_readable($___fullPathToFile)) {
			ob_start();
			include $___fullPathToFile;
			return ob_get_clean();
		}
		else {
			throw new \Exception('View ' . $file . ' cannot be included', 500);
		}
	}
	
	public function __set($name, $value) {
		$this->___data[$name] = $value;
	}
	
	public function __get($name) {
		return $this->___data[$name];
	}
	
	public static function getInstance() {
		if (self::$_instance == null) {
			self::$_instance = new \GF\View();
		}
		
		return self::$_instance;
	}
}