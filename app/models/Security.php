<?php
	

class Security extends Eloquent{
	protected $table = "qes_u_security";
	protected $userId = "userId";
	protected $questionId = "questionId";
	protected $answer = "answer";

	public function __construct(){
		$this->primaryKey = $this->userId;
	}
	
	public function userMain(){
		return $this->belongsTo("userMain","userId","id");
	}
	public function Uquestion(){
		return $this->hasOne("Uquestion","id","questionId");
	}
}

?>