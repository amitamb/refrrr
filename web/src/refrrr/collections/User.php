<?php 

require_once('framework/basicFrameworkInclude.php');

define ("SHOW_LOGIN", "showLogin");
define ("SHOW_REGISTER", "showRegister");
define ("PROCESS_REGISTER", "processRegister");
define ("PROCESS_LOGIN", "processLogin");
define ("LOGOUT", "logout");

define('USERNAME', 'username');
define('USERID', 'userid');
define('PASSWORD', 'password');
define('PASSWORD', 'password');
define('CONFIRM_PASSWORD', 'confirmPassword');

class User
{
	public static function processMethod($method)
	{
		if ($method == PROCESS_LOGIN)
		{
			User::processLogin();			
		}
		elseif ($method == SHOW_LOGIN)
		{
			User::showLogin();
		}
		else if ($method == PROCESS_REGISTER)
		{
			User::processRegister();			
		}
		elseif ($method == SHOW_REGISTER)
		{
			User::showRegister();
		}
		elseif ($method == LOGOUT)
		{
			User::logout();
		}
	}	
	
	public static function showLogin()
	{
		$username = requestParam(USERNAME);
		
		//Show login
		$inputs = array();
		
		$inputs[] = new Input('text', USERNAME, USERNAME, $username, 'Email');
		$inputs[] = new Input('password', PASSWORD, PASSWORD, '', 'Password');
		$inputs[] = new Input('hidden', METHOD, METHOD, PROCESS_LOGIN, '');
		$inputs[] = new Input('submit', '', '', 'Submit', '');
		
		showForm($inputs, 'user.php', POST);
	}
	
	public static function showLogoutButton()
	{
		print "<a href='user.php?".METHOD."=".LOGOUT."'>Logout</a>";		
	}

	public static function processLogin()
	{
		$username = requestParam(USERNAME);
		$password = requestParam(PASSWORD);
		if (User::isCredentialsCorrect($username, $password))
		{
			session_start();
			session_destroy();
			session_start();
			$_SESSION[USERNAME]=$username;
			$_SESSION[USERID]=$username;
			redirectSuccess('index.php');
		}
		else
		{
			//redirectFailure('user.php?'.METHOD."=".SHOW_LOGIN);
			showErrorMessage("Wrong credentials");
			User::showLogin();
		}
	}
	
	public static function logout()
	{
		session_start();
		session_destroy();
		redirectSuccess('index.php');
	}
	
	public static function isLoggedIn()
	{
		session_start();
		if (isset($_SESSION[USERNAME]))
		{
			return true;			
		}
		else
		{
			return false;			
		}
	}
	
	public static function showRegister()
	{
		$username = requestParam(USERNAME);
		
		//Show register
		$inputs = array();
		
		$inputs[] = new Input('text', USERNAME, USERNAME, $username, 'Username');
		$inputs[] = new Input('password', PASSWORD, PASSWORD, '', 'Password');
		$inputs[] = new Input('password', CONFIRM_PASSWORD, CONFIRM_PASSWORD, '', 'Confirm Password');
		$inputs[] = new Input('hidden', METHOD, METHOD, PROCESS_REGISTER, '');
		$inputs[] = new Input('submit', '', '', 'Submit', '');
		
		showForm($inputs, 'user.php', POST);
	}
	
	public static function processRegister()
	{
		$username = requestParam(USERNAME);
		$password = requestParam(PASSWORD);
		$confirmPassword = requestParam(CONFIRM_PASSWORD); 
		
		if ($password != $confirmPassword)
		{
			showErrorMessage("Password and confirm password do not match.");
			User::showRegister();
		}
		else
		{
			
			redirectSuccess('index.php');
		}
	}
	
	public static function getId()
	{
		session_set_cookie_params(31556926);

		session_start();
		if (isset($_SESSION[USERID]))
		{
			return $_SESSION[USERID];
		}
		else
		{
			// for now user's session id will be user name
			return session_id();
		}
	}

//	
//	Following code actually communicates with DB and does DB modifications so be careful
//	

	
	
	public static function isCredentialsCorrect($username, $password)
	{
		if ($username == "amit" && $password == "amit")
		{
			return true;
		}
		else
		{
			return false;			
		}
	}	
}

?>
