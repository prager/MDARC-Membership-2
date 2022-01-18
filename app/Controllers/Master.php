<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Master extends BaseController {
	var $username;

/**
* Controller for the webmaster
*/
	public function index() {
		if($this->check_master()) {
				echo view('template/header_master.php');
				echo view('master/master_view.php');
	    }
	    else {
					$this->login_mod->logout();
					echo view('template/header');
	        $data['title'] = 'Login Error';
	        $data['msg'] = 'There was an error while checking your credentials. Click ' . anchor('Home/reset_password', 'here') . ' to reset your password <br><br>';
	        echo view('status/status_view', $data);
	    }
			echo view('template/footer');
	}

	public function show_members() {
		if($this->check_master()) {
			echo view('template/header_master');
			$param['states'] = $this->data_mod->get_states_array();
			$param['lic'] = $this->data_mod->get_lic();
			$param['mem_types'] = $this->master_mod->get_member_types();
			echo view('master/members_view', $this->staff_mod->get_mems($param));
		}
		else {
			echo view('template/header');
			$data['title'] = 'Authorization Error';
			$data['msg'] = 'You may not be authorized to view this page. Go back and try again ' . anchor(base_url(), 'here'). '<br><br>';
			echo view('status/status_view', $data);
		}
		echo view('template/footer');
	}

	public function delete_mem() {
		if($this->check_master()) {
			$this->uri->setSilent();
			$this->staff_mod->delete_mem($this->uri->getSegment(2));
			$this->show_members();
		}
		else {
			echo view('template/header');
			$data['title'] = 'Authorization Error';
			$data['msg'] = 'You may not be authorized to view this page. Go back and try again ' . anchor(base_url(), 'here'). '<br><br>';
			echo view('status/status_view', $data);
			echo view('template/footer');
		}
	}

	public function un_delete_mem() {
		if($this->check_master()) {
			$this->uri->setSilent();
			$this->staff_mod->un_delete_mem($this->uri->getSegment(2));
			$this->show_members();
		}
		else {
			echo view('template/header');
			$data['title'] = 'Authorization Error';
			$data['msg'] = 'You may not be authorized to view this page. Go back and try again ' . anchor(base_url(), 'here'). '<br><br>';
			echo view('status/status_view', $data);
			echo view('template/footer');
		}
	}

	public function set_silent() {
		if($this->check_master()) {
			$this->uri->setSilent();
			$param['id'] = $this->uri->getSegment(2);
			$param['silent_date'] =  time();
			$param['usr_type'] = 98;
			$param['silent_year'] = date('Y', $param['silent_date']);
			$this->staff_mod->set_silent($param);
			$this->show_members();
		}
		else {
			echo view('template/header');
			$data['title'] = 'Authorization Error';
			$data['msg'] = 'You may not be authorized to view this page. Go back and try again ' . anchor(base_url(), 'here'). '<br><br>';
			echo view('status/status_view', $data);
			echo view('template/footer');
		}
	}

	public function unset_silent() {
		if($this->check_master()) {
			$this->uri->setSilent();
			$this->staff_mod->unset_silent($this->uri->getSegment(2));
			$this->show_members();
		}
		else {
			echo view('template/header');
			$data['title'] = 'Authorization Error';
			$data['msg'] = 'You may not be authorized to view this page. Go back and try again ' . anchor(base_url(), 'here'). '<br><br>';
			echo view('status/status_view', $data);
			echo view('template/footer');
		}
	}


		public function edit_mem() {
				if($this->check_master()) {
					echo view('template/header_master');
					$param['email'] =  trim($this->request->getPost('email'));
					$param['callsign'] =  trim($this->request->getPost('callsign'));
					$param['paym_date'] = strtotime($this->request->getPost('pay_date'));
					$param['address'] = $this->request->getPost('address');
					$param['city'] = $this->request->getPost('city');
					$param['state'] = $this->request->getPost('state');
					$param['zip'] = $this->request->getPost('zip');
					$param['fname'] = $this->request->getPost('fname');
					$param['lname'] = trim($this->request->getPost('lname'));
					$param['license'] = $this->request->getPost('sel_lic');
					$param['cur_year'] = trim($this->request->getPost('cur_year'));
					$param['mem_since'] = trim($this->request->getPost('mem_since'));
					$param['w_phone'] = $this->request->getPost('w_phone');
					$param['h_phone'] = $this->request->getPost('h_phone');
					$param['comment'] = trim($this->request->getPost('comment'));
					$param['id_mem_types'] = $this->request->getPost('mem_types');
					$param['timestamp'] = time();
					$email = $this->request->getPost('email');
					//echo '<br><br><br>mem type: ' . $this->request->getPost('mem_types');
					filter_var($email, FILTER_VALIDATE_EMAIL) ? $param['email'] = $email : $param['email'] = 'none';
					$this->request->getPost('arrl') == 'on' ? $param['arrl_mem'] = 'TRUE' : $param['arrl_mem'] = 'FALSE';
					$this->request->getPost('hard_news') == 'on' ? $param['hard_news'] = 'TRUE' : $param['hard_news'] = 'FALSE';
					$this->request->getPost('dir') == 'on' ? $param['hard_dir'] = 'TRUE' : $param['hard_dir'] = 'FALSE';
					$this->request->getPost('mem_card') == 'on' ? $param['mem_card'] = 'TRUE' : $param['mem_card'] = 'FALSE';

					$this->uri->setSilent();
					$param['id'] = $this->uri->getSegment(2);

					if ($this->staff_mod->edit_mem($param)) {
						$param['states'] = $this->data_mod->get_states_array();
						$param['lic'] = $this->data_mod->get_lic();
						$param['member_types'] = $this->master_mod->get_member_types();
						echo view('master/members_view', $this->staff_mod->get_mems($param));
					}
					else {
						$data['title'] = 'Douplicate Entry Error!';
						$data['msg'] = 'This is duplicate entry. The member ' . $param['lname'] . ' with callsign ' . $param['callsign'] . ' is already in the database.<br><br>';
						$data['msg'] .= 'Go back to ' . anchor('members', 'members listing');
						echo view('status/status_view', $data);
					}
				}
			else {
				echo view('template/header');
				$data['title'] = 'Authorization Error';
				$data['msg'] = 'You may not be authorized to view this page. Go back and try again ' . anchor(base_url(), 'here'). '<br><br>';
				echo view('status/status_view', $data);
			}
			echo view('template/footer');
		}

		public function purge_mem() {
			if($this->check_master()) {
				$this->uri->setSilent();
				$this->staff_mod->purge_mem($this->uri->getSegment(2));
				$this->show_members();
			}
			else {
				echo view('template/header');
				$data['title'] = 'Authorization Error';
				$data['msg'] = 'You may not be authorized to view this page. Go back and try again ' . anchor(base_url(), 'here'). '<br><br>';
				echo view('status/status_view', $data);
				echo view('template/footer');
			}
		}
			public function add_fam_mem() {
				if($this->check_master()) {
					$this->uri->setSilent();
					$param['parent_primary'] = $this->uri->getSegment(2);
					$param['callsign'] =  trim($this->request->getPost('callsign'));
					$param['fname'] = $this->request->getPost('fname');
					$param['lname'] = trim($this->request->getPost('lname'));
					$param['license'] = $this->request->getPost('sel_lic');
					$param['w_phone'] = $this->request->getPost('w_phone');
					$param['h_phone'] = $this->request->getPost('h_phone');
					$param['id_mem_types'] = $this->request->getPost('mem_types');
					$param['mem_type'] = $this->staff_mod->get_mem_types()[$param['id_mem_types']];
					$param['active'] = TRUE;
					$param['mem_since'] = date('Y', time());
					$param['comment'] = $this->request->getPost('comment');
					$email = $this->request->getPost('email');
					filter_var($email, FILTER_VALIDATE_EMAIL) ? $param['email'] = $email : $param['email'] = 'none';
					$this->request->getPost('arrl') == 'on' ? $param['arrl_mem'] = 'TRUE' : $param['arrl_mem'] = 'FALSE';
					$this->mem_mod->add_fam_mem($param);
					$this->show_members();
				}
				else {
					echo view('template/header');
					$this->login_mod->logout();
		      $data['title'] = 'Login Error';
		      $data['msg'] = 'There was an error while checking your credentials.<br><br>';
		      echo view('status/status_view.php', $data);
				}
			}
				public function edit_fam_mem() {
					if($this->check_master()) {
						$this->uri->setSilent();
						$param['id'] = $this->uri->getSegment(2);
						$param['callsign'] =  trim($this->request->getPost('callsign'));
						$param['fname'] = $this->request->getPost('fname');
						$param['lname'] = trim($this->request->getPost('lname'));
						$param['license'] = $this->request->getPost('sel_lic');
						$param['w_phone'] = $this->request->getPost('w_phone');
						$param['h_phone'] = $this->request->getPost('h_phone');
						$param['id_mem_types'] = $this->request->getPost('mem_types');
						$param['mem_type'] = $this->staff_mod->get_mem_types()[$param['id_mem_types']];
						$param['active'] = TRUE;
						$param['comment'] = $this->request->getPost('comment');
						$email = $this->request->getPost('email');
						filter_var($email, FILTER_VALIDATE_EMAIL) ? $param['email'] = $email : $param['email'] = 'none';
						$this->request->getPost('arrl') == 'on' ? $param['arrl_mem'] = 'TRUE' : $param['arrl_mem'] = 'FALSE';
						$this->mem_mod->edit_fam_mem($param);
						$this->show_members();
					}
					else {
						echo view('template/header');
						$this->login_mod->logout();
			      $data['title'] = 'Login Error';
			      $data['msg'] = 'There was an error while checking your credentials.<br><br>';
			      echo view('status/status_view.php', $data);
					}
				}

				public function delete_fam_mem() {
					if($this->check_master()) {
						$this->uri->setSilent();
						$this->mem_mod->delete_fam_mem($this->uri->getSegment(2));
						$this->show_members();
					}
					else {
						echo view('template/header');
						$data['title'] = 'Authorization Error';
						$data['msg'] = 'You may not be authorized to view this page.<br><br>';
						echo view('status/status_view', $data);
					}
					echo view('template/footer');
				}
/**
* Checks for master user according to the type code
*/
	private function check_master() {
		$retval = FALSE;
		$user_arr = $this->login_mod->get_cur_user();
		if(($user_arr != NULL) && ($user_arr['type_code'] == 99 && $user_arr['authorized'] == 1)) {
			$retval = TRUE;
		}
		return $retval;
	}

	public function download_user_types() {
		if($this->check_master()) {
			$this->master_mod->put_user_types();
			return $this->response->download('files/user_types.csv', NULL);
		}
	}

	public function download_users() {
		if($this->check_master()) {
			$this->master_mod->put_users();
			return $this->response->download('files/users.csv', NULL);
		}
	}
/**
* Enables master user edit users
*/
	public function edit_users() {
	 echo view('template/header_master');
	 if($this->check_master()) {
		 $data = $this->master_mod->get_users_data();
		 $data['states'] = $this->data_mod->get_states_array();
		 $data['msg'] = NULL;
		 $data['errmsg'] = NULL;
		 echo view('master/edit_users_view', $data);
		 }
		 else {
				 $data['title'] = 'Login Error';
				 $data['msg'] = 'There was an error while checking your credentials. Click ' . anchor('Home/reset_password', 'here') .
				 ' to reset your password or go to home page ' . anchor('Home', 'here'). '<br><br>';
				 echo view('status/status_view', $data);
		 }
		 echo view('template/footer');

	}
	/**
	* Saves the updated admin user data into db
	*/
	public function load_admin() {
		if($this->check_master()) {
			echo view('template/header_master');
			$param['id_user'] = $this->uri->getSegment(2);
			$param['fname'] = $this->request->getPost('fname');
			$param['lname'] = $this->request->getPost('lname');
			$param['phone'] = $this->request->getPost('phone');
			$param['facebook'] = $this->request->getPost('facebook');
			$param['twitter'] = $this->request->getPost('twitter');
			$param['linkedin'] = $this->request->getPost('linkedin');
			$param['email'] = $this->request->getPost('email');
			$param['street'] = $this->request->getPost('street');
			$param['city'] = $this->request->getPost('city');
			$param['state_cd'] = $this->request->getPost('state');
			$param['zip_cd'] = $this->request->getPost('zip');
			$param['comment'] = $this->request->getPost('comment');
			$param['callsign'] = $this->request->getPost('callsign');
			$param['id_user_type'] = $this->request->getPost('usr_type');
			$this->master_mod->load_admin($param);
			$data = $this->master_mod->get_users_data();
			$data['states'] = $this->data_mod->get_states_array();
			$data['msg'] = 'Updated user. Thank you!';
			$data['errmsg'] = NULL;
			echo view('master/edit_users_view', $data);
		}
		else {
				echo view('template/header');
 				 $data['title'] = 'Login Error';
 				 $data['msg'] = 'There was an error while checking your credentials. Click ' . anchor('Home/reset_password', 'here') .
 				 ' to reset your password or go to home page ' . anchor('Home', 'here'). '<br><br>';
 				 echo view('status/status_view', $data);
		}
		echo view('template/footer');
	}

	public function delete_user() {
		if($this->check_master()) {
			echo view('template/header_master');
			 $this->master_mod->delete_user($this->uri->getSegment(2));
			 $data = $this->master_mod->get_users_data();
	 		 $data['states'] = $this->data_mod->get_states_array();
			 $data['msg'] = 'Deleted user. Thank you!';
			 $data['errmsg'] = NULL;
	 		 echo view('master/edit_users_view', $data);
		}
		else {
			echo view('template/header');
			 $data['title'] = 'Login Error';
			 $data['msg'] = 'There was an error while checking your credentials. Click ' . anchor('Home/reset_password', 'here') .
			 ' to reset your password or go to home page ' . anchor('Home', 'here'). '<br><br>';
			 echo view('status/status_view', $data);
		}
		echo view('template/footer');
	}

	public function authorize() {
		if($this->check_master()) {
			echo view('template/header_master');
			 $this->master_mod->authorize($this->uri->getSegment(2));
			 $data = $this->master_mod->get_users_data();
	 		 $data['states'] = $this->data_mod->get_states_array();
			 $data['msg'] = 'Authorized / Unauthorized user. Thank you!';
			 $data['errmsg'] = NULL;
	 		 echo view('master/edit_users_view', $data);
		}
		else {
			echo view('template/header');
			 $data['title'] = 'Login Error';
			 $data['msg'] = 'There was an error while checking your credentials. Click ' . anchor('Home/reset_password', 'here') .
			 ' to reset your password or go to home page ' . anchor('Home', 'here'). '<br><br>';
			 echo view('status/status_view', $data);
		}
		echo view('template/footer');
	}

	public function activate() {
		if($this->check_master()) {
			echo view('template/header_master');
			 $this->master_mod->activate($this->uri->getSegment(2));
			 $data = $this->master_mod->get_users_data();
	 		 $data['states'] = $this->data_mod->get_states_array();
			 $data['msg'] = 'Activated / deactivated user. Thank you!';
			 $data['errmsg'] = NULL;
	 		 echo view('master/edit_users_view', $data);
		}
		else {
			echo view('template/header');
			 $data['title'] = 'Login Error';
			 $data['msg'] = 'There was an error while checking your credentials. Click ' . anchor('Home/reset_password', 'here') .
			 ' to reset your password or go to home page ' . anchor('Home', 'here'). '<br><br>';
			 echo view('status/status_view', $data);
		}
		echo view('template/footer');
	}

	public function reset_user() {
		if($this->check_master()) {
			echo view('template/header_master');
				$param['id_user'] = $this->uri->getSegment(2);
				$param['username'] = $this->request->getPost('username');
				$param['pass'] = $this->request->getPost('pass');
				$param['pass2'] = $this->request->getPost('pass2');
				$flags = $this->master_mod->reset_user($param);
				if ($flags['flag']) {
 			 		$data = $this->master_mod->get_users_data();
		 		 	$data['states'] = $this->data_mod->get_states_array();
				 	$data['msg'] = 'Username and pasword were succesfuly reset. Thank you!';
					$data['errmsg'] = NULL;
		 		  echo view('master/edit_users_view', $data);
				}
				else {
					$data['errmsg'] = 'Please, fix the following error(s):<br>';
					$data['id_user'] = $param['id_user'];
					if($flags['usr_dup']) $data['errmsg'] .= '<p style="color:red;">Duplicate username</p>';
					if(!($flags['pass_match'])) $data['errmsg'] .= '<p style="color:red;">Passwords do not match</p>';
					if(!($flags['pass_comp'])) $data['errmsg'] .= '<p style="color:red;">Password complexity requirement not met</p>';
					echo view('master/set_pass_view', $data);
				}
		}
		else {
			echo view('template/header');
			 $data['title'] = 'Login Error';
			 $data['msg'] = 'There was an error while checking your credentials. Click ' . anchor('Home/reset_password', 'here') .
			 ' to reset your password or go to home page ' . anchor('Home', 'here'). '<br><br>';
			 echo view('status/status_view', $data);
		}
		echo view('template/footer');
	}

	public function mem_types() {
		$this->master_mod->set_mem_type();
		if($this->check_master()) {
				echo view('template/header_master');
				echo view('master/master_view');
			}
			else {
					echo view('template/header');
					$data['title'] = 'Login Error';
					$data['msg'] = 'There was an error while checking your credentials. Click ' . anchor('Home/reset_password', 'here') .
					' to reset your password or go to home page ' . anchor('Home', 'here'). '<br><br>';
					echo view('status/status_view', $data);
			}
			echo view('template/footer');
	}

	public function convert_callsign() {
		echo view('template/header_master');
		$this->master_mod->convert_to_callsign($this->request->getPost('tbl'));
		$data['title'] = 'Done!';
		$data['msg'] = 'Callsign converted. <br><br>';
		echo view('status/status_view', $data);
		echo view('template/footer');
	}

	public function add_mem() {
		if($this->check_master()) {
			echo view('template/header_master');
			$data['states'] = $this->data_mod->get_states_array();
			$data['lic'] = $this->data_mod->get_lic();
			$data['mem_types'] = $this->master_mod->get_member_types();
			echo view('master/add_mem_view', $data);
		}
		else {
			echo view('template/header');
			$data['title'] = 'Login Error';
			$data['msg'] = 'There was an error while checking your credentials. Click ' . anchor('Home/reset_password', 'here') .
			' to reset your password or go to home page ' . anchor('Home', 'here'). '<br><br>';
			echo view('status/status_view', $data);
		}
		echo view('template/footer');
	}
}
