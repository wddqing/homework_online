<?php

class profiles extends Eloquent{
	protected $table = "qes_u_profiles";
	protected $id = "id";
	protected $nickName = "nickName";
	protected $jobId = "jobId";
	protected $trueName = "trueName";

	public function __construct(){
		$this->primaryKey = $this->id;
	}
	public function userMain(){
		return $this->belongTo("userMain","id","id");
	}

}
?>