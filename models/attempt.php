<?php
/**
@todo: Keeping score based solely on IP address is flawed. If you are in an internet cafe. Or even at home but there are 4 computers, the fourth person WON"T log in ause they all share one IP address. So, IP + session is the way to go... and a cookie. And if there is no cookie, then it's a hacker and fuXk his ass
*/
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