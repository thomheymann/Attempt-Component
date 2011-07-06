<?php
class Attempt extends AppModel {
	var $name = 'Attempt';
	var $displayField = 'ip';
	
	public function count($ip, $action) {
		return $this->find('count', array(
			'conditions' => array(
				'ip' => $ip,
				'action' => $action,
				'expires >' => date('Y-m-d H:i:s')
				)
			));
	}
	
	public function limit($ip, $action, $limit) {
		return ($this->count($ip, $action) < $limit);
	}
	
	public function fail($ip, $action, $duration) {
		$this->create(array(
			'ip' => $ip,
			'action' => $action,
			'expires' => date('Y-m-d H:i:s', strtotime($duration)),
			));
		return $this->save();
	}
	
	public function reset($ip, $action) {
		return $this->deleteAll(array(
			'ip' => $ip,
			'action' => $action
			), false, false);
	}
	
	public function cleanup() {
		return $this->deleteAll(array(
			'expires <' => date('Y-m-d H:i:s')
			), false, false);
	}
}
?>