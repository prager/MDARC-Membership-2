<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Login extends BaseController {
	var $username;
	public function index() {
		//echo '<br><br><br><br>ok!';
	 if($this->validate_credentials()) {
			$data['title'] = 'You Are Logged In!';
			$data['msg'] = 'Click below to continue on your main page:';
			echo view('template/header_member');
			echo view('status/status_view', $data);
      echo view('template/footer');
	  }
    else {
      echo view('template/header');
      $data['title'] = '<p style="color: red;">Login Error';
      $data['msg'] = 'There was an error while checking your credentials. Please, check your username and password. Thank you!<br><br>';
      echo view('status/status_view', $data);
      echo view('template/footer');
		}
	}

	public function load_user() {
	    echo view('template/header');
			$login_mod = new \App\Models\Login_model();
	    $flag = $login_mod->check_table($login_mod->get_cur_user_id());

	    $data['user'] = $login_mod->get_cur_user($login_mod->get_cur_user_id());

	    echo view('admin/admin_view', $data);
	    echo view('template/footer');
	}

	public function validate_credentials() {
	    $this->username = strtolower($this->request->getPost('user'));
	    $password = $this->request->getPost('pass');
	    $data['user'] = $this->username;
	    $data['pass'] = $password;
			return $this->login_mod->check_credentials($data);
	}

}
