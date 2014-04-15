<?php
	

class Utype extends Eloquent{
	protected $table = "qes_u_type";
	
	protected $id = "id";
	protected $type = "type";
	
	public function __construct(){
		$this->primaryKey = $this->id;
	}
	
	public function userMain(){
		return $this->belongsTo("userMain","id","id");
	}
	
}

?>