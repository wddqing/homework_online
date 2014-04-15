<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
	
class userMain extends Eloquent implements UserInterface, RemindableInterface{
	protected $table = "qes_u_main";
	
	protected $userId = 'id';
	
	protected $email = 'email';
	
	protected $password = 'password';
	
	protected $vaild = 'vaild';
	
	protected $vaildCode = 'vaildCode';
	

	//开启软删除
	//protected $softDelete = true;
	
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');
	
	public function __construct(){
		$this->primaryKey = $this->userId;
	}
	
	
	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	*/
	public function getAuthIdentifier()
	{
		return $this->userId;
	}
	
	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}
	
	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}
	
	public function Security(){
		return $this->hasOne("Security","userId","id");
	}
	
	public function profiles(){
		return $this->hasOne("profiles","id","id");
	}
	
	public function Utype(){
		return $this->hasOne('Utype',"id","id");
	}
	
	
}

?>