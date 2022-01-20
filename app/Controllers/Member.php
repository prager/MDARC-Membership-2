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
			$data['user'] = $this->login_mod->get_cur_user();
			$mem_arr = $this->mem_mod->get_mem($data['user']['id_user']);
			$data['primary'] = $mem_arr['primary'];
			$data['fam_arr'] = $this->mem_mod->get_fam_mems($data['user']['id_user']);
			$data['member_types'] = $this->master_mod->get_member_types();
			$data['lic'] = $this->data_mod->get_lic();
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

/**
* Loads personal data into the form and displays it
*/
  public function pers_data() {
    if($this->check_mem()) {
	  	echo view('template/header_member.php');
			$data['user'] = $this->login_mod->get_cur_user();
			$mem_arr = $this->mem_mod->get_mem($data['user']['id_user']);
			$data['mem'] = $mem_arr['primary'];
			$data['fam_arr'] = $this->mem_mod->get_fam_mems($data['user']['id_user']);
			$data['member_types'] = $this->master_mod->get_member_types();
			$data['states'] = $this->data_mod->get_states_array();
			$data['lic'] = $this->data_mod->get_lic();
			$data['msg'] = '';
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

	public function update_mem() {
		if($this->check_mem()) {
			$this->uri->setSilent();
			$param['id'] = $this->uri->getSegment(2);
			$param['email'] =  trim($this->request->getPost('email'));
			$param['callsign'] =  trim($this->request->getPost('callsign'));
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

			if(count($update_arr) > 0) {
				$val_str = '';
				foreach ($update_arr as $key => $value) {
					$val_str .= $value;
				}
				$data['title'] = 'Error(s)';
				$data['msg'] = $val_str;
			}
			else {
				$data['title'] = 'Success!';
				$data['msg'] = '<p class="text-danger fw-bold">Your changes have been saved<br>';
			}

			//$data['msg'] .= 'Id: ' . $param['id'];
      echo view('status/status_view.php', $data);
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
			$this->request->getPost('dir_ok') == 'on' ? $param['ok_mem_dir'] = 'TRUE' : $param['ok_mem_dir'] = 'FALSE';
			$ret_str = $this->mem_mod->add_fam_mem($param);

			echo view('template/header_member');
			if($ret_str == NULL) {
				$data['title'] = 'Success!';
				$data['msg'] = '<p class="text-danger fw-bold">Your changes have been saved<br>';
			}
			else {
	      $data['title'] = 'Error!';
	      $data['msg'] = $ret_str;
			}
			echo view('status/status_view.php', $data);
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
				$param['callsign'] =  trim($this->request->getPost('callsign'));
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
				$email = $this->request->getPost('email');
				filter_var($email, FILTER_VALIDATE_EMAIL) ? $param['email'] = $email : $param['email'] = 'none';
				$this->request->getPost('arrl') == 'on' ? $param['arrl_mem'] = 'TRUE' : $param['arrl_mem'] = 'FALSE';
				$this->request->getPost('dir_ok') == 'on' ? $param['ok_mem_dir'] = 'TRUE' : $param['ok_mem_dir'] = 'FALSE';
				$this->mem_mod->edit_fam_mem($param);

				$data['msg'] ='';
				$flag = TRUE;
				echo view('template/header_member');
				if(!$w_phone['flag']){
					$data['msg'] .= '<p class="text-danger fw-bold">Cell phone was in wrong format and was not saved.</p>';
					$flag = FALSE;
				}

				if(!$h_phone['flag']) {
					$data['msg'] .= '<p class="text-danger fw-bold">Other phone number was in wrong format and was not saved.</p>';
					$flag = FALSE;
				}

				if($flag) {
					$data['title'] = 'Success!';
					$data['msg'] = '<p class="text-danger fw-bold">Your changes have been saved<br>';
				}
				else {
					$data ['title'] = 'Error!';
				}
				echo view('status/status_view.php', $data);
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
		if((($user_arr != NULL) && ($user_arr['type_code'] == 99)) || (($user_arr['authorized'] == 1) && ($user_arr['type_code'] < 90))) {
			$retval = TRUE;
		}
		return $retval;
	}

	public function delete_fam_mem() {
		if($this->check_mem()) {
			$this->uri->setSilent();
			$this->mem_mod->delete_fam_mem($this->uri->getSegment(2));
			$this->index();
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
