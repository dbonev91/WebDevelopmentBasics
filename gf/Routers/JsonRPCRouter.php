<?php
	
namespace GF\Routers;
class JsonRPCRouter implements \GF\Routers\IRouter {
	private $_map = array();
	private $_requestId;
	
	public function __construct() {
		$notJSONRequest = $_SERVER['REQUEST_METHOD'] != 'POST' ||
			empty($_SERVER['CONTENT_TYPE']) ||
			$_SERVER['CONTENT_TYPE'] != 'application/json';
			
		if ($notJSONRequest) {
			throw new \Exception('Require JSON request', 500);
		}
	}
	
	public function setMethodsMap($arrayMethod) {
		if (is_array($arrayMethod)) {
			$this->_map = $arrayMethod;
		}
	}
	
	public function getURI() {
		if (!is_array($this->_map) || count($this->_map) == 0) {
			$arrayMethods = \GF\App::getInstance()->getConfig()->rpcRoutes;
			
			if (is_array($arrayMethods) && count($arrayMethods) > 0) {
				$this->_map = $arrayMethods;
			}
			else {
				throw new \Exception('Router requires method map', 500);
			}
		}
		
		$request = json_decode(file_get_contents('php://input'), true);
		if (!is_array($request) || !isset($request['method'])) {
			throw new \Exception('Require JSON request', 400);
		}
		else {
			if ($this->_map[$request['method']]) {
				$this->_requestId = $request['id'];
				return $this->_map[$request['method']];
			}
			else {
				throw new \Exception('Method not found', 501);
			}
		}
	}
	
	public function getRequestId() {
		return $this->_requestId;
	}
}