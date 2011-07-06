Attempt Component
=================

A simple component to protect sensitive actions from brute force attacks.


API
---

### count($action)
Returns the number of failed attempts for a certain action.

### limit($action, $limit = 5)
Returns false if the number of failed attempts is bigger than the passed limit.

### fail($action, $duration = '+10 minutes')
Creates a failed attempt that counts towards the limit for the passed duration

### reset($action)
Deletes all failed attempts for a certain action

### cleanup()
Deletes all expired failed attempts from the database. This should be run via CakeShell every now and then. 


Schema
------

	CREATE TABLE `attempts` (
	  `id` char(36) NOT NULL DEFAULT '',
	  `ip` varchar(64) DEFAULT NULL,
	  `action` varchar(32) DEFAULT NULL,
	  `created` datetime DEFAULT NULL,
	  `expires` datetime DEFAULT NULL,
	  PRIMARY KEY (`id`),
	  KEY `ip` (`ip`,`action`),
	  KEY `expires` (`expires`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8


Example Implementation
----------------------

	class ExampleController extends Controller {
		
		var $components = array(
			'Attempt'
			);
		
		var $loginAttemptLimit = 10;
		var $loginAttemptDuration = '+1 hour';
		
		public function login() {
			// Form submitted?
			if ( $formSubmitted = true ) {
				// All required fields entered?
				if ( $validFormData = true ) {
					// Limit to 10 failed attempts
					if ( $this->Attempt->limit('login', $this->loginAttemptLimit) ) {
						// Validate user credentials
						if ( $validCredentials = true ) {
							// Log user in
						} else {
							// Invalid credentials, count as failed attempt for an hour
							$this->Attempt->fail('login', $this->loginAttemptDuration);
							$this->Session->setFlash('Unknown user or wrong password');
						}
					} else {
						// User exceeded attempt limit
						// Ideally show a CAPTCHA (ensuring this is not a robot 
						// without blocking out and frustrating users),
						// otherwise show error message
						$this->Session->setFlash('Too many failed attempts!');
					}
				} else {
					// Invalid form data but keep it ambiguous
					$this->Session->setFlash('Unknown user or wrong password');
				}
			}
		}
	}
