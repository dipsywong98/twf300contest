<?php 

class GameletLoginVerification {
	
	function __construct($username, $password) {
		
		if (!$username || !$password) {
			throw new Exception("Username or password cannot be empty", 1);
		}

		$this->username = $username;
		$this->password = $password;

	}

	private function _checkLogin() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://tw.gamelet.com/gwtremoting/userService");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:text/x-gwt-rpc; charset=UTF-8'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_buildPayload());

		$server_output = curl_exec($ch);
		curl_close ($ch);

		$this->_returnHeader = $server_output;
	}

	private function _buildPayload(){

		return "7|0|8|https://tw.gamelet.com/gwt/com.liquable.lumix.gwt.user.User/|43790D39328D68AC0B320A9537E906C1|com.liquable.lumix.gwt.service.client.GwtUserService|loginFromGwt|java.lang.String/2004016611|Z|".$this->username."|".$this->password."|1|2|3|4|3|5|5|6|7|8|0|";

	}

	public function isValid(){
		$this->_checkLogin();
		return (bool)preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $this->_returnHeader);
	}
}


 ?>