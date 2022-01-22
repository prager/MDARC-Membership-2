<?php

namespace App\Controllers;

class Home extends BaseController {
  public function index() {
		echo view('template/header');
		if(!($this->login_mod->is_logged())) {
			echo view('public/main_view', array('msg' => ''));
		}
		else {
			return redirect()->route($this->login_mod->get_cur_user()['controller']);
		}
		echo view('template/footer');
  }

  public function contact() {
    if(!($this->login_mod->is_logged())) {
      echo view('template/header');
    }
    else {
      echo view('template/header_' . $this->login_mod->get_cur_user()['controller']);
    }
    echo view('public/contact_view');
    echo view('template/footer');
  }

  public function send_contact() {
    echo view('template/header');
    $param['fname'] = $this->request->getPost('fname');
    $param['lname'] = $this->request->getPost('lname');
    $param['email'] = $this->request->getPost('email');
    $param['msg'] = $this->request->getPost('msg');
    $flag = $this->home_mod->contact($param);
    if($flag) {
      $data['title'] = 'Message was sent!';
      $data['msg'] = '<p class="text-danger">Your message was sent.</p> Thank you for visiting our web portal!.<br><br>';
      echo view('status/status_view', $data);
    }
    else {
      $data['title'] = 'Error!';
      $data['msg'] = '<p class="text-danger">There was an error.</p> Thank you for visiting our web portal!.<br><br>';
      $data['msg'] .= 'fname: ' . $param['fname'];
      echo view('status/status_view', $data);
    }
    echo view('template/footer');
  }

/**
* Loads up the blank registration form
*/
  public function register() {
  	echo view('template/header');
  	$new_usr = $this->mem_mod->get_member_by_email(strtolower($this->request->getPost('email')));
  	if($new_usr['flag']) {
  		$data = array();
  		helper(['form', 'url']);
  		$data['fname'] = $new_usr['fname'];
  		$data['lname'] = $new_usr['lname'];
  		$data['email'] = $new_usr['email'];
  		$data['callsign'] = $new_usr['callsign'];
  		$data['phone'] = $new_usr['phone'];
  		$data['street']= $new_usr['address'];
  		$data['city'] = $new_usr['city'];
  		$data['state_cd'] = $new_usr['state'];
  		$data['zip_cd'] = $new_usr['zip'];
  		$data['msg'] = '';
  		$data['twitter'] = '';
  		$data['facebook'] = '';
  		$data['linkedin'] = '';
  		$data['googleplus'] = '';
  		$data['user_types'] = $this->user_mod->get_user_types();
  		$data['states'] = $this->data_mod->get_states_array();
  		echo view('public/register_view', $data);
  	}
  	else {
  		$data['title'] = 'Error!';
      if($new_usr['empty']) {
        $data['msg'] = 'Please, enter your email.<br><br>';
      }
      else {
  			$data['msg'] = '<p class="text-danger">There was an error processing your data.</p> Most likely you either used a wrong email or you are not an MDARC member.<br><br>';
      }
  		echo view('status/status_view', $data);
  	}
  	echo view('template/footer');
  }

/**
* The first step of user registration when the user sends the initial data. The second step will include setting the username and password
* via the confirm_reg() below
*/
	public function send_reg() {
		helper(['form', 'url']);
		$param = array();
    $param['fname'] = $this->request->getPost('fname');
    $param['lname'] = $this->request->getPost('lname');
    $param['email'] = $this->request->getPost('email');
    $param['street'] = $this->request->getPost('street');
    $param['city'] = $this->request->getPost('city');
    $param['state_cd'] = $this->request->getPost('state_cd');
    $param['zip_cd'] = $this->request->getPost('zip_cd');
    $param['phone'] = $this->request->getPost('phone');
    $param['callsign'] = $this->request->getPost('callsign');
    $param['facebook'] = $this->request->getPost('facebook');
    $param['twitter'] = $this->request->getPost('twitter');
    $param['linkedin'] = $this->request->getPost('linkedin');
    $param['id_user_type'] = 0;

		$email_flag = TRUE;
		if (!filter_var($param['email'], FILTER_VALIDATE_EMAIL)) {
  		$email_flag = FALSE;
		}

		$isPhoneNum = FALSE;
		//eliminate every char except 0-9
		$justNums = preg_replace("/[^0-9]/", '', $param['phone']);

		//eliminate leading 1 if its there
		if (strlen($justNums) == 11) $justNums = preg_replace("/^1/", '',$justNums);

		//if we have 10 digits left, it's probably valid.
		if (strlen($justNums) == 10) $isPhoneNum = TRUE;

		$param['ip'] = $this->get_ip();

		//echo 'ip: ' . $param['ip'];
		echo view('template/header');
		if($param['lname'] == '' || $param['fname'] == '' || $email_flag == FALSE || $param['street'] == '' || $param['city'] == '' || $param['zip_cd'] == ''
				|| $isPhoneNum == FALSE || $param['fname'] == $param['lname']) {
            $data = $param;
            $data['state_cd'] = $param['state_cd'];
            $data['zip_cd'] = $param['zip_cd'];
            $data['phone'] = $param['phone'];
            $data['title'] = 'Error!';
            $data['msg'] = '<span style="color: red">Please, fill all the required information marked by *. Thank you!</span>';
            if(!$email_flag) {
              $data['msg'] .= ' Note: Your email is wrong';
            }
            elseif(!$isPhoneNum) {
              $data['msg'] .= ' Note: Your email is wrong';
            }
						$data['states'] = $this->data_mod->get_states_array();
						$data['user_types'] = $this->user_mod->get_user_types();
            echo view('public/register_view', $data);
        }
        else {
					$retarr = $this->user_mod->register($param);
          if($retarr['flag']) {

              $data['title'] = 'Thank you!';

							$msg_str = 'Your registration has been sent. You will get an email with further instructions within 72 hours.<p class="text-danger"> Please, also check your spam messages since this email can be wrongly flagged as spam by your email server.</p> Thank you! <br><br>';

							//$msg_str = 'Still working on it. Check again later. Click to go back to ' . anchor(base_url(), 'home page here') . '<br><br>';

              $data['msg'] = $msg_str;
          }
          else {
              $data['title'] = 'Error!';
              $data['msg'] = '<span style="color: red">' . $retarr['msg'];
          }
          echo view('status/status_view', $data);
        }
        echo view('template/footer');
    	}

    /**
    * This is called by clicking on the emailed URL to confirm registration by setting up username and password
    */
    	public function set_pass() {
    			$this->uri->setSilent();
    	    echo view('template/header');
    			$data['email_key'] = $this->uri->getSegment(2);
    			$data['msg'] = '';
    			echo view('public/set_pass_view', $data);
    	    echo view('template/footer');
    	}

      public function change_pass() {
    			$this->uri->setSilent();
    	    echo view('template/header');
    			$data['email_key'] = $this->uri->getSegment(2);
    			$data['msg'] = '';
    			echo view('public/change_pass_view', $data);
    	    echo view('template/footer');
    	}

    	/**
    	* This is called by clicking on the emailed URL to confirm registration by setting up username and password
    	*/
    		public function reset_password() {
    				$this->uri->setSilent();
    		    echo view('template/header');
    				$data['email_key'] = '';
    				$data['msg'] = '';
    				echo view('public/reset_pass_view', $data);
    		    echo view('template/footer');
    		}

    	/**
    	* This is the final step for the user registration when he will send his username and password.
    	* When these are saved the master user will approve him and only then the user will gain
    	* appropriate access according his user profile
    	* Also can be used for username and password reset (still todo)
    	*/
    	public function set_user() {
    		echo view('template/header');
    		$param['flag'] = TRUE;
    		$param['email_key'] = $this->uri->getSegment(2);
    		$param['pass'] = $this->request->getPost('pass');
    		$param['pass2'] = $this->request->getPost('pass2');
    		$param['username'] = strtolower($this->request->getPost('username'));
    		$flags_arr = $this->user_mod->set_user($param);
    		if($flags_arr['flag']) {
    			$data['title'] = 'Username and Password Set!';
    			$data['msg'] = 'You still need to be authorized by the system admin and will be notified soon.
    			<br><br>Thank you for your interest in MDARC Members Portal! <br><br>You can go back to home page by clicking '
    			 		. anchor('Home', 'here'). '<br><br>';
    			echo view('status/status_view', $data);
    		}
    		else {
    			$data['msg'] = 'Please, fix the following error(s):<br>';
    			$data['id_user'] = $flags_arr['id_user'];
    			if($data['id_user'] > 0) {
    				if($flags_arr['usr_dup']) $data['msg'] .= '<p style="color:red;">Duplicate username</p>';
    				if(!($flags_arr['pass_match'])) $data['msg'] .= '<p style="color:red;">Passwords do not match</p>';
    				if(!($flags_arr['pass_comp'])) $data['msg'] .= '<p style="color:red;">Password complexity requirement not met</p>';
    				$data['email_key'] = $flags_arr['email_key'];
    				echo view('public/set_pass_view', $data);
    			}
    			else {
    				$data['title'] = 'Error!';
    				$data['msg'] = 'There was an error processing your data. <br><br>You can go back to home page by clicking '
    				 		. anchor('Home', 'here'). '<br><br>';
    				echo view('status/status_view', $data);
    			}
    		}

    		echo view('template/footer');
    	}

      public function change_user_pass() {
    		echo view('template/header');
    		$param['flag'] = TRUE;
    		$param['email_key'] = $this->uri->getSegment(2);
    		$param['pass'] = $this->request->getPost('pass');
    		$param['pass2'] = $this->request->getPost('pass2');
    		$param['username'] = strtolower($this->request->getPost('username'));
    		$flags_arr = $this->user_mod->change_user_pass($param);
    		if($flags_arr['flag']) {
    			$data['title'] = 'Username and Password Set!';
    			$data['msg'] = 'Now you can go back to home page and login with your new password.';
    			echo view('status/status_view', $data);
    		}
    		else {
    			$data['msg'] = 'Please, fix the following error(s):<br>';
    			$data['id_user'] = $flags_arr['id_user'];
    			if($data['id_user'] > 0) {
    				if(!($flags_arr['pass_match'])) $data['msg'] .= '<p style="color:red;">Passwords do not match</p>';
    				if(!($flags_arr['pass_comp'])) $data['msg'] .= '<p style="color:red;">Password complexity requirement not met. Password needs to contain at least one uppercase letter, one lowercase letter, one number and one special character in addition to be between 8 and 20 characters long.</p>';
    				$data['email_key'] = $flags_arr['email_key'];
    				echo view('public/set_pass_view', $data);
    			}
    			else {
    				$data['title'] = 'Error!';
    				$data['msg'] = 'There was an error processing your data. <br><br>You can try again or contact the administrator. <br><br>';
            foreach($flags_arr as $key => $value) {
              //$value ? $data['msg'] .= $key . ' ' . 'OK<br>' : $data['msg'] .= $key . ' ' . 'Not OK<br>';
            }
    				echo view('status/status_view', $data);
    			}
    		}

    		echo view('template/footer');
    	}

/**
* Recovers lost password
*/
    public function load_password() {
    	echo view('template/header');
    	$param['email'] = $this->request->getPost('email');
    	$flags = $this->user_mod->load_password($param);
    	if(!(filter_var($param['email'], FILTER_VALIDATE_EMAIL))) {
        $data['title'] = 'Email Error!';
        $data['msg'] = '<p class="text-danger">Enter a valid email</p>. Please, go back and try again. Thank you!<br><br>';
        echo view('status/status_view', $data);
    	}
    	elseif(!$flags['flag']) {
        $data['title'] = 'Email Error!';
        $data['msg'] = '<p class="text-danger">You entered a wrong email. Please, go back and try again.</p> Thank you!<br><br>';
        echo view('status/status_view', $data);
    	}
    	elseif(!$flags['db_flag']) {
        $data['title'] = 'DB Error!';
        $data['msg'] = '<p class="text-danger">There was a DB error</p>. Please, try again later. Thank you!<br><br>';
        echo view('status/status_view', $data);
    	}
      else {
        $data['title'] = 'Password Change Request Sent!';
    		$data['msg'] = 'Change password link was sent to your email. Thank you for using our Membership Portal!<br>';
    		echo view('status/status_view', $data);
      }
    	echo view('template/footer');
    }
    
    /**
    * Self-explanatory: calls the logout function from Loging_model
    */
    	public function logout() {
    		$this->login_mod->logout();
    		echo view('template/header');
    		echo view('public/main_view', array('msg' => '<p class="text-success lead"><i class="bi bi-check-circle"></i> You have succesfuly logged out. Thank you and have a great day!</p>'));
    		echo view('template/footer');
    	}

    public function new_username() {
    	echo view('template/header');
    	echo view('public/change_username_view', array('msg' => ''));
    	echo view('template/footer');
    }

    public function email_username() {
    echo view('template/header');
    echo view('public/email_username_view', array('msg' => ''));
    echo view('template/footer');
    }

    public function set_username() {
    	$id = $this->user_mod->get_id_by_email($this->request->getPost('email'));
    	echo view('template/header');
    	if($id > 0) {
    	  echo view('public/set_username_view', array('id' => $id, 'msg' => '', 'id' => $id));
    	}
    	else {
    		$data['title'] = 'Error!';
    		$data['msg'] = 'There was an error processing your data. <br><br>You can go back to home page by clicking '
    				. anchor('Home', 'here'). '<br><br>';
    		echo view('status/status_view', $data);
    	}
    	echo view('template/footer');
    }

    public function load_username() {
    	echo view('template/header');
    	$param['username'] = $this->request->getPost('username');
    	$param['username2'] = $this->request->getPost('username2');
    	$param['id_user'] = $this->uri->getSegment(2);
    	if($this->user_mod->load_username($param)) {
    		$data['title'] = 'Username Set!';
    		$data['msg'] = 'Your username was reset. You may go back to home page by clicking '
    				. anchor('Home', 'here'). '<br><br>';
    	  echo view('status/status_view', $data);
    	}
    	else {
    		$data['title'] = 'Error!';
    		$data['msg'] = 'There was an error processing your data. <br><br>You can go back to home page by clicking '
    				. anchor('Home', 'here'). '<br><br>';
    		echo view('status/status_view', $data);
    	}
    	echo view('template/footer');
    }

    public function lost_username() {
    	$flag = $this->user_mod->lost_username($this->request->getPost('email'));
    	echo view('template/header');
    	if($flag) {
    		$data['title'] = 'Username Sent!';
    		$data['msg'] = 'Your username was sent to your email. You may go back to home page by clicking '
    				. anchor('Home', 'here'). '<br><br>';
    	  echo view('status/status_view', $data);
    	}
    	else {
    		$data['title'] = 'Error!';
    		$data['msg'] = 'There was an error processing your data. <br><br>You can go back to home page by clicking '
    				. anchor('Home', 'here'). '<br><br>';
    		echo view('status/status_view', $data);
    	}
    	echo view('template/footer');
    }

    /**
    * Inspired by: https://www.w3resource.com/php-exercises/php-basic-exercise-5.php
    */
    	private function get_ip() {
    		$ip_address = NULL;
    		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        	$ip_address = $_SERVER['HTTP_CLIENT_IP'];
      	}
    	//whether ip is from proxy
    		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    		  $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    		}
    	//whether ip is from remote address
    		else {
    		  $ip_address = $_SERVER['REMOTE_ADDR'];
    		}
    		return $ip_address;
    	}

      public function test_foo() {
        echo "OK!<br>";

      	$param['username'] = strtolower($this->request->getPost('username'));
        echo '<br><br><br>username: ' . $param['username'];
      }

    }
