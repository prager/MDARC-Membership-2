<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Staff extends BaseController {
	var $username;
/**
* Controller for MDARC Staff
*/
	public function index() {
		if($this->check_staff()) {
		  	echo view('template/header_staff');
				echo view('staff/staff_view');
	    }
	    else {
			  echo view('template/header');
				$this->login_mod->logout();
				$data['title'] = 'Login Error';
				$data['msg'] = 'There was an error while checking your credentials. <br><br>';
				echo view('status/status_view', $data);
	    }
			echo view('template/footer');
	}

	public function show_members() {
		if($this->check_staff()) {
			echo view('template/header_staff');
			$param['states'] = $this->data_mod->get_states_array();
			$param['lic'] = $this->data_mod->get_lic();
			echo view('staff/members_view', $this->staff_mod->get_mems($param));
		}
		else {
			echo view('template/header');
			$data['title'] = 'Authorization Error';
			$data['msg'] = 'You may not be authorized to view this page. Go back and try again ' . anchor(base_url(), 'here'). '<br><br>';
			echo view('status/status_view', $data);
		}
		echo view('template/footer');
	}

	public function add_mem() {
		if($this->check_staff()) {
			echo view('template/header_staff');
			echo view('staff/add_mem_view', array('states' => $this->data_mod->get_states_array(), 'lic' => $this->data_mod->get_lic()));
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

	private function check_staff() {
		$retval = FALSE;
		$user_arr = $this->login_mod->get_cur_user();
		if($user_arr != NULL) {
			if((($user_arr['type_code'] == 99)) || (($user_arr['authorized'] == 1) && ($user_arr['type_code'] == 3))) {
				$retval = TRUE;
			}
		}
		return $retval;
	}

	public function download_due_emails() {
		if($this->check_staff())
			return $this->response->download('files/due-emails.txt', NULL);
	}

	public function download_cur_emails() {
		if($this->check_staff())
			return $this->response->download('files/cur-emails.txt', NULL);
	}

	public function download_address_lbls() {
		if($this->check_staff())
			return $this->response->download('files/address-lbls.txt', NULL);
	}

	public function download_all_mems() {
		if($this->check_staff())
			return $this->response->download('files/all_members.csv', NULL);
	}

	public function download_pay_due() {
		if($this->check_staff())
			return $this->response->download('files/pay_due.csv', NULL);
	}

	public function download_cur_mems() {
		if($this->check_staff())
			return $this->response->download('files/curr_mems.csv', NULL);
	}

	public function download_pay_next_mems() {
		if($this->check_staff())
			return $this->response->download('files/pay-next-emails.txt', NULL);
	}

	public function update_cur_yr() {
		echo view('template/header');
		$this->staff_mod->update_cur_yr();
		$data['title'] = 'Good to Go';
		$data['msg'] = 'Good to go. You can go home ' . anchor('Home', 'here'). '<br><br>';
		$data['title'] = 'OK!';
		$data['msg'] = 'Go home ' . anchor(base_url(), 'here'). '<br><br>';
		echo view('status/status_view', $data);
		echo view('template/footer');
	}

	public function edit_mem() {
			if($this->check_staff()) {
				echo view('template/header_staff');
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
				$param['id_mem_types'] = 1;
				$param['timestamp'] = time();
				$email = $this->request->getPost('email');
				//echo '<br><br><br>arrl: ' . $this->request->getPost('state');
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
					echo view('staff/members_view', $this->staff_mod->get_mems($param));
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

	public function delete_mem() {
		if($this->check_staff()) {
			echo view('template/header_staff');
			$this->uri->setSilent();
			$this->staff_mod->delete_mem($this->uri->getSegment(2));
			$param['states'] = $this->data_mod->get_states_array();
			$param['lic'] = $this->data_mod->get_lic();
			echo view('staff/members_view', $this->staff_mod->get_mems($param));
		}
		else {
			echo view('template/header');
			$data['title'] = 'Authorization Error';
			$data['msg'] = 'You may not be authorized to view this page. Go back and try again ' . anchor(base_url(), 'here'). '<br><br>';
			echo view('status/status_view', $data);
		}
		echo view('template/footer');
	}

		public function un_delete_mem() {
			if($this->check_staff()) {
				echo view('template/header_staff');
				$this->uri->setSilent();
				$this->staff_mod->un_delete_mem($this->uri->getSegment(2));
				$param['states'] = $this->data_mod->get_states_array();
				$param['lic'] = $this->data_mod->get_lic();
				echo view('staff/members_view', $this->staff_mod->get_mems($param));
			}
			else {
				echo view('template/header');
				$data['title'] = 'Authorization Error';
				$data['msg'] = 'You may not be authorized to view this page. Go back and try again ' . anchor(base_url(), 'here'). '<br><br>';
				echo view('status/status_view', $data);
			}
			echo view('template/footer');
		}

/**
* Temporary routine to add silent keys to the main table
*/
	public function set_silents() {
		echo view('template/header');
		$data['title'] = 'Set Silent Keys';
		$this->staff_mod->set_silents();
		$data['msg'] = 'Silent keys set -> go home ' . anchor('Home', 'here'). '<br><br>';
		echo view('status/status_view', $data);
		echo view('template/footer');
	}

/**
* This will be scrapped and handled by edit_mem()
*/
	public function set_silent() {
		if($this->check_staff()) {
			echo view('template/header_staff');
			$this->uri->setSilent();
			$param['id'] = $this->uri->getSegment(2);
			$param['silent_date'] =  time();
			$param['usr_type'] = 98;
			$param['silent_year'] = date('Y', $param['silent_date']);
			$this->staff_mod->set_silent($param);
			$param['states'] = $this->data_mod->get_states_array();
			$param['lic'] = $this->data_mod->get_lic();
			echo view('staff/members_view', $this->staff_mod->get_mems($param));
		}
		else {
			echo view('template/header');
			$data['title'] = 'Authorization Error';
			$data['msg'] = 'You may not be authorized to view this page. Go back and try again ' . anchor(base_url(), 'here'). '<br><br>';
			echo view('status/status_view', $data);
		}
		echo view('template/footer');
	}

	public function unset_silent() {
		if($this->check_staff()) {
			echo view('template/header_staff');
			$this->uri->setSilent();
			$this->staff_mod->unset_silent($this->uri->getSegment(2));
			$param['states'] = $this->data_mod->get_states_array();
			$param['lic'] = $this->data_mod->get_lic();
			echo view('staff/members_view', $this->staff_mod->get_mems($param));
		}
		else {
			echo view('template/header');
			$data['title'] = 'Authorization Error';
			$data['msg'] = 'You may not be authorized to view this page. Go back and try again ' . anchor(base_url(), 'here'). '<br><br>';
			echo view('status/status_view', $data);
		}
		echo view('template/footer');
	}

/**
* Generates report for MDARC Staff
*/
	public function staff_report() {
		if($this->check_staff()) {
			echo view('template/header_staff');
			$this->uri->setSilent();
			if($this->uri->getSegment(2) != "") {
				$param['date_start'] = strtotime($this->request->getPost('date_start'));
				$param['date_stop'] = strtotime($this->request->getPost('date_stop'));
			}
			else {
				$param['date_start'] = time() - (60 * 60 * 24 * 30);
				$param['date_stop'] = time();
			}
			echo view('staff/staff_report_view', $this->staff_mod->get_rep($param));
		}
		else {
			echo view('template/header');
			$data['title'] = 'Authorization Error';
			$data['msg'] = 'You may not be authorized to view this page. Go back and try again ' . anchor(base_url(), 'here'). '<br><br>';
			echo view('status/status_view', $data);
		}
		echo view('template/footer');
	}

	public function load_silent() {
		if($this->check_staff()) {
			echo view('template/header');
				$this->uri->setSilent();
				$param['silent_date'] = strtotime($this->request->getPost('silent_date'));
				$param['silent_year'] = date('Y', $param['silent_date']);
				$param['id'] = $this->uri->getSegment(2);
				$this->staff_mod->set_silent($param);
				$param['states'] = $this->data_mod->get_states_array();
				$param['lic'] = $this->data_mod->get_lic();
				echo view('staff/members_view', $this->staff_mod->get_mems($param));
				$data['title'] = 'OK';
				$data['msg'] = 'OK thank you <br><br>';
		}
		else {
			echo view('template/header');
			$data['title'] = 'Authorization Error';
			$data['msg'] = 'You may not be authorized to view this page. Go back and try again ' . anchor(base_url(), 'here'). '<br><br>';
			echo view('status/status_view', $data);
		}
		echo view('template/footer');
	}

	public function print_dir() {
		if($this->check_staff()) {
			echo view('template/header_staff');
			$param['states'] = $this->data_mod->get_states_array();
			$param['lic'] = $this->data_mod->get_lic();
			echo view('staff/print_dir_view', $this->staff_mod->get_mems($param));
		}
		else {
			echo view('template/header');
			$data['title'] = 'Authorization Error';
			$data['msg'] = 'You may not be authorized to view this page. Go back and try again ' . anchor(base_url(), 'here'). '<br><br>';
			echo view('status/status_view', $data);
		}
		echo view('template/footer');
	}

	/**
	* Temporary routine to verify payments
	*/
	public function verify_payment() {
			echo view('template/header');
			$retarr = $this->staff_mod->verify_payment();
			$data['msg'] = 'Members corrected: <br>';
			foreach($retarr as $mem) {
				$data['msg'] .= $mem['lname'] . ' ' . $mem['fname'] . ' | ' . $mem['pay_date'] . '<br>';
			}
			$data['msg'] .= 'Total count: ' . count($retarr) . '<br>';
	//for now; perhaps do some report
			$data['title'] = 'Payment Verified';
			$data['msg'] .= '<br>Go home ' . anchor('Home', 'here'). '<br><br>';
			echo view('status/status_view', $data);
			echo view('template/footer');
	}

	public function purge_mem() {
		if($this->check_staff()) {
			echo view('template/header_staff');
			$this->uri->setSilent();
			$this->staff_mod->purge_mem($this->uri->getSegment(2));
			$param['states'] = $this->data_mod->get_states_array();
			$param['lic'] = $this->data_mod->get_lic();
			echo view('staff/members_view', $this->staff_mod->get_mems($param));
		}
		else {
			echo view('template/header');
			$data['title'] = 'Authorization Error';
			$data['msg'] = 'You may not be authorized to view this page. Go back and try again ' . anchor(base_url(), 'here'). '<br><br>';
			echo view('status/status_view', $data);
		}
		echo view('template/footer');
	}
}
