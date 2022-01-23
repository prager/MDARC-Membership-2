<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Member extends BaseController {
	var $username;

/**
* Controller for the webmaster
*/
	public function index() {
    if($this->check_mem()) {
	  	echo view('template/header_member.php');
			$data = $this->get_mem_data();
			$data['msg'] = '';
			echo view('members/member_view.php', $data);
	   }
    else {
	  	echo view('template/header');
			$this->login_mod->logout();
      $data['title'] = 'Login Error';
      $data['msg'] = 'There was an error while checking your credentials.<br><br>';
      echo view('status/status_view.php', $data);
    }
		echo view('template/footer.php');
	}

	private function get_mem_data() {
		$data['user'] = $this->login_mod->get_cur_user();
		$mem_arr = $this->mem_mod->get_mem($data['user']['id_user']);
		$data['primary'] = $mem_arr['primary'];
		$data['fam_arr'] = $this->mem_mod->get_fam_mems($data['user']['id_user']);
		$data['member_types'] = $this->master_mod->get_member_types();
		$data['lic'] = $this->data_mod->get_lic();
		return $data;
	}

/**
* Loads personal data into the form and displays it
*/
  public function pers_data() {
    if($this->check_mem()) {
	  	echo view('template/header_member.php');
			$data = $this->get_pers_data();
			$data['msg'] = NULL;
			$data['errors'] = array();
			$data['errors']['cell'] = NULL;
			$data['errors']['phone'] = NULL;
			$data['errors']['email'] = NULL;
			$data['errors']['callsign'] = NULL;
			echo view('members/pers_data_view.php', $data);
	   }
    else {
	  	echo view('template/header');
			$this->login_mod->logout();
      $data['title'] = 'Login Error';
      $data['msg'] = 'There was an error while checking your credentials.<br><br>';
      echo view('status/status_view.php', $data);
    }
		echo view('template/footer.php');
  }

	private function get_pers_data() {
		$data['user'] = $this->login_mod->get_cur_user();
		$mem_arr = $this->mem_mod->get_mem($data['user']['id_user']);
		$data['mem'] = $mem_arr['primary'];
		$data['fam_arr'] = $this->mem_mod->get_fam_mems($data['user']['id_user']);
		$data['member_types'] = $this->master_mod->get_member_types();
		$data['states'] = $this->data_mod->get_states_array();
		$data['lic'] = $this->data_mod->get_lic();
		$data['errors']['cell'] = NULL;
		$data['errors']['phone'] = NULL;
		$data['errors']['email'] = NULL;
		$data['errors']['callsign'] = NULL;
		return $data;
	}

	public function update_mem() {
		if($this->check_mem()) {
			$this->uri->setSilent();
			$param['id'] = $this->uri->getSegment(2);
			$param['email'] =  strtolower(trim($this->request->getPost('email')));
			$param['callsign'] = strtoupper(trim($this->request->getPost('callsign')));
			$param['address'] = $this->request->getPost('address');
			$param['city'] = $this->request->getPost('city');
			$param['state'] = $this->request->getPost('state');
			$param['zip'] = $this->request->getPost('zip');
			$param['fname'] = $this->request->getPost('fname');
			$param['lname'] = trim($this->request->getPost('lname'));
			$param['license'] = $this->request->getPost('sel_lic');
			$param['w_phone'] = $this->request->getPost('w_phone');
			$param['h_phone'] = $this->request->getPost('h_phone');
			$email = $this->request->getPost('email');
			$this->request->getPost('dir_ok') == 'on' ? $param['ok_mem_dir'] = 'TRUE' : $param['ok_mem_dir'] = 'FALSE';
			filter_var($email, FILTER_VALIDATE_EMAIL) ? $param['email'] = $email : $param['email'] = 'none';
			$this->request->getPost('arrl') == 'on' ? $param['arrl_mem'] = 'TRUE' : $param['arrl_mem'] = 'FALSE';

			$update_arr = $this->mem_mod->update_mem($param);
			echo view('template/header_member.php');

			if(!$update_arr['flag']) {
				$val_str = '';
				foreach ($update_arr['msg'] as $key => $value) {
					if($value != NULL) {$val_str .= $value . '<br>';}
				}
				$data = $this->get_pers_data();
				$data['msg'] = '<p class="text-danger"><strong>Errors!</strong> ';
				$data['msg'] .= $val_str . '</p>';
				$data['errors'] = $update_arr['msg'];
	      echo view('members/pers_data_view.php', $data);
			}
			else {
				$data = $this->get_mem_data();
				$data['msg'] = '<p class="text-success"><strong>Success!</strong> ';
				$data['msg'] .= 'Your changes have been saved</p>';
				echo view('members/member_view.php', $data);
			}
		}
		else {
			echo view('template/header');
			$this->login_mod->logout();
      $data['title'] = 'Login Error';
      $data['msg'] = 'There was an error while checking your credentials.<br><br>';
      echo view('status/status_view.php', $data);
		}
		echo view('template/footer.php');
	}

	public function add_fam_mem() {
		if($this->check_mem()) {
			$this->uri->setSilent();
			$param['parent_primary'] = $this->uri->getSegment(2);
			$param['callsign'] =  strtoupper(trim($this->request->getPost('callsign')));
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
			$email = strtolower($this->request->getPost('email'));
			filter_var($email, FILTER_VALIDATE_EMAIL) ? $param['email'] = $email : $param['email'] = 'none';
			$this->request->getPost('arrl') == 'on' ? $param['arrl_mem'] = 'TRUE' : $param['arrl_mem'] = 'FALSE';
			$this->request->getPost('dir_ok') == 'on' ? $param['ok_mem_dir'] = 'TRUE' : $param['ok_mem_dir'] = 'FALSE';
			$ret_str = $this->mem_mod->add_fam_mem($param);

			echo view('template/header_member');
			if($ret_str == NULL) {
				$data = $this->get_mem_data();
				$data['msg'] = '<p class="text-success fw-bold">Your family member was added!<br>';
				echo view('members/member_view.php', $data);
			}
			else {
	      $data = $this->get_pers_data();
	      $data['msg'] = $ret_str;
				echo view('members/pers_data_view.php', $data);
			}
			echo view('template/footer');
		}
		else {
			echo view('template/header');
			$this->login_mod->logout();
      $data['title'] = 'Login Error';
      $data['msg'] = 'There was an error while checking your credentials.<br><br>';
      echo view('status/status_view.php', $data);
			echo view('template/footer');
		}
	}
		public function edit_fam_mem() {
			if($this->check_mem()) {
				$this->uri->setSilent();
				$param['id'] = $this->uri->getSegment(2);
				$param['callsign'] = strtoupper(trim($this->request->getPost('callsign')));
				$param['fname'] = $this->request->getPost('fname');
				$param['lname'] = trim($this->request->getPost('lname'));
				$param['license'] = $this->request->getPost('sel_lic');
				$w_phone = $this->mem_mod->do_phone($this->request->getPost('w_phone'));
				$h_phone = $this->mem_mod->do_phone($this->request->getPost('h_phone'));
				$param['w_phone'] = $w_phone['phone'];
				$param['h_phone'] = $h_phone['phone'];
				$param['id_mem_types'] = $this->request->getPost('mem_types');
				$param['mem_type'] = $this->staff_mod->get_mem_types()[$param['id_mem_types']];
				$param['active'] = TRUE;
				$param['comment'] = $this->request->getPost('comment');
				$email = strtolower($this->request->getPost('email'));
				filter_var($email, FILTER_VALIDATE_EMAIL) ? $param['email'] = $email : $param['email'] = 'none';
				$this->request->getPost('arrl') == 'on' ? $param['arrl_mem'] = 'TRUE' : $param['arrl_mem'] = 'FALSE';
				$this->request->getPost('dir_ok') == 'on' ? $param['ok_mem_dir'] = 'TRUE' : $param['ok_mem_dir'] = 'FALSE';
				$ret_str = $this->mem_mod->edit_fam_mem($param);

				$data = $this->get_pers_data();
				$data['msg'] = '';

				$flag = TRUE;
				echo view('template/header_member');
				if(!$w_phone['flag']){
					$data['msg'] .= '<br><span class="text-danger">Family member cell phone was in wrong format and was not saved.</span>';
					$flag = FALSE;
				}

				if(!$h_phone['flag']) {
					$data['msg'] .= '<br><span class="text-danger">Family member other phone number was in wrong format and was not saved.</span>';
					$flag = FALSE;
				}

				if($ret_str != NULL) {
					$data['msg'] .= '<br><span class="text-danger">Family member error(s): ' . $ret_str . '</span>';
					$flag = FALSE;
				}

				if($flag) {
					$data['msg'] = '<p class="text-success"><strong>Success!</strong> ';
					$data['msg'] .= 'Your changes to family member data have been saved</p>';
				}

				echo view('members/pers_data_view.php', $data);
				echo view('template/footer');

			}
			else {
				echo view('template/header');
				$this->login_mod->logout();
	      $data['title'] = 'Login Error';
	      $data['msg'] = 'There was an error while checking your credentials.<br><br>';
	      echo view('status/status_view.php', $data);
			}
		}

  public function check_mem() {
		$retval = FALSE;
		$user_arr = $this->login_mod->get_cur_user();
		if($user_arr == NULL) {
			$retval = FALSE;
		}
		elseif((($user_arr['type_code'] == 99)) || (($user_arr['authorized'] == 1) && ($user_arr['type_code'] < 90))) {
			$retval = TRUE;
		}
		return $retval;
	}

	public function delete_fam_mem() {
		if($this->check_mem()) {
			$this->uri->setSilent();
			$this->mem_mod->delete_fam_mem($this->uri->getSegment(2));
			echo view('template/header_member');
			$data = $this->get_mem_data();
			$data['msg'] = '<p class="text-danger fw-bold">Your family member was deleted!<br>';
			echo view('members/member_view.php', $data);
		}
		else {
			echo view('template/header');
			$data['title'] = 'Authorization Error';
			$data['msg'] = 'You may not be authorized to view this page.<br><br>';
			echo view('status/status_view', $data);
		}
		echo view('template/footer');
	}

}
