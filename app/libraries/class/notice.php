<?php

	class notice{
		
		public $notice;
		public $welcome;
		public $urlName;
		public $redirect;
		
		
		/**
	 * @return the $redirect
	 */
	public final function getRedirect() {
		return $this->redirect;
	}

		/**
	 * @param field_type $redirect
	 */
	public final function setRedirect($redirect) {
		$this->redirect = $redirect;
	}

		//在用户没登陆情况下，提示信息并进行跳转
		public function __construct($notice,$welcome,$urlName){
			$this->notice = $notice;
			$this->welcome = $welcome;
			$this->urlName = $urlName;
		}
		
		
		public function getMessage(){
			$result = array();
			$result['notice'] = $this->notice;
			$result['welcome'] = $this->welcome;
			$result['urlName'] = $this->urlName;
			if(isset($this->redirect) && $this->redirect >= 0){
				$result['redirect'] = $this->redirect;
			}
			return $result;
		}
		
		
	}
?>