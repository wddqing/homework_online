<?php

class Uquestion extends Eloquent{
	protected $table = "qes_u_question";
	protected $id = "id";
	protected $question = "question";

	public function __construct(){
		$this->primaryKey = $this->id;
	}

	public function Security(){
		return $this->belongsTo("Security","id","questionId");
	}
}
?>