<?php
namespace GF\Session;

class DBSession extends \GF\DB\SimpleDB implements \GF\Session\ISession {
	private $sessionName;
	private $tableName;
	private $lifetime;
	private $path;
	private $domain;
	private $secure;
	private $sessionId = null;
	private $sessionData = array();
	
	public function __construct ($dbConnection, $name, $tableName = 'session', $lifetime = 3600, $path = null, $domain = null, $secure = null) {
		parent::__construct($dbConnection);
		
		$this->tableName = $tableName;
		$this->sessionName = $name;
		$this->lifetime = $lifetime;
		$this->path = $path;
		$this->domain = $domain;
		$this->secure = $secure;
		$this->sessionId = $_COOKIE[$name];
		
		// pseudo garbadge collector
		$is50thQuery = (rand (0, 50) == 1);
		if ($is50thQuery) {
			// $this->_garbadgeCollector();
		}
		
		if (strlen($this->sessionId) < 32) {
			$this->_startNewSession();
		}
		else if (!$this->_validateSession()) {
			$this->_startNewSession();
		}
	}
	
	private function _startNewSession () {
		$this->sessionId = md5(uniqid('gf', TRUE));
		$this->prepare("INSERT INTO " . $this->tableName . " (sessid, valid_until) VALUES(?, ?)",
			array($this->sessionId, (time() + $this->lifetime)))->execute();
		setcookie($this->sessionName, $this->sessionId,
			(time() + $this->lifetime), $this->path, $this->domain, $this->secure, true);
	}
	
	private function _validateSession () {
		if ($this->sessionId) {
			$currentSession = $this->prepare("SELECT * FROM " . $this->tableName . " WHERE sessid=? AND valid_until<=?",
				array($this->sessionId, (time() + $this->lifetime)))->execute()->fetchAllAssoc();
			
			if (is_array($currentSession) && count($currentSession) == 1 && $currentSession[0]) {
				$this->sessionData = unserialize($currentSession[0]['sess_data']);
				return true;
			}
		}
		
		return false;
	}
	
	public function getSessionId() {
		return $this->sessionId;
	}
	
	public function saveSession() {
		if ($this->sessionId) {
			$this->prepare("UPDATE " . $this->tableName . " SET sess_data=?, valid_until=? WHERE sessid=?",
				array(serialize($this->sessionData), (time() + $this->lifetime), $this->sessionId))->execute();
			setcookie($this->sessionName, $this->sessionId, (time() + $this->lifetime), $this->path, $this->domain, $this->secure, true);
		}
	}
	
	public function destroySession() {
		if ($this->sessionId) {
			$this->prepare('DELETE FROM ' . $this->tableName . ' WHERE sessid=?', array($this->sessionId))->execute();
		}
	}
	
	public function __get($name) {
		return $this->sessionData[$name];
	}
	
	public function __set($name, $value) {
		$this->sessionData[$name] = $value;
	}
	
	public function _garbadgeCollector() {
		$this->prepare('DELETE FROM `' . $this->tableName . '` WHERE valid_until<?', array(time()))->execute();
	}
}