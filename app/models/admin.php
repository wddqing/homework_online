<?php

class admin extends Eloquent{
	protected $table = "qes_u_manager";

	protected $id = "id";
	protected $loginName = "loginName";
	protected $password = "password";
	protected $type = "type";

	
	public function __construct(){
		$this->primaryKey = $this->id;
	}

}
?>