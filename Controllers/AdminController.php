<?php

require_once(get_include_path()."\Projects\aiub project\Models\AdminModel.php");
require_once(get_include_path()."\Projects\aiub project\Models\UserModel.php");
require_once(get_include_path()."\Projects\aiub project\Controllers\login_controller.php");
class AdminController extends Login{
	private $admin;
	function AdminController()
	{
		Login::Login();
		$this->admin = new AdminModel();
	}
	function checkAdmin($value , $pass , $key)
	{
		$this->queryResult = $this->admin->adminValidity($value , $pass , $key);
		if($this->queryResult)
		{
			return true;
		}
		else
			return false;
	}

	function getAllUsers()
	{
		return $this->user->getAllUsers();
	}
	function isLogged()
	{
		if($this->role == 1 && $this->logged)
			return true;
		else
			return false;
	}
	function getRoleName($role)
	{
		return $this->user->getRoleName($role);
	}
	function getAllUsersExcept($id)
	{
		return $this->user->getAllUsersExcept($id);
	}

}



?>
