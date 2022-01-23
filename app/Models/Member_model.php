<?php namespace App\Models;

use CodeIgniter\Model;

/**
* This model is to collect rank and file member data
*/
class Member_model extends Model {
  var $db;

  public function __construct()  {
        parent::__construct();
  }

  public function get_mem($id) {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $db->close();
    $builder->where('id_users', $id);
    $elem = array();
    if($builder->countAllResults() > 0) {
      $builder->resetQuery();
      $builder->where('id_users', $id);
      $member = $builder->get()->getRow();
      $elem['id_members'] = $member->id_members;

  //set the true or false values for boolean db entries
      $elem['carrier'] = trim(strtoupper($member->hard_news));
      $elem['dir'] = trim(strtoupper($member->hard_dir));
      $elem['arrl'] =  trim(strtoupper($member->arrl_mem));
      $elem['dir_ok'] =  trim(strtoupper($member->ok_mem_dir));
      $elem['mem_card'] = trim(strtoupper($member->mem_card));
      $member->h_phone == NULL ? $elem['h_phone'] = '000-000-0000' : $elem['h_phone'] = $member->h_phone;
      $member->w_phone == NULL ? $elem['w_phone'] = '000-000-0000' : $elem['w_phone'] = $member->w_phone;
      $member->comment == NULL ? $elem['comment'] = '' : $elem['comment'] = $member->comment;
      $elem['phone_unlisted'] = $member->h_phone_unlisted;
      $elem['cell_unlisted'] = $member->w_phone_unlisted;
      $elem['email_unlisted'] = $member->email_unlisted;
      $elem['fname'] = $member->fname;
      $elem['lname'] = $member->lname;
      $member->address == NULL ? $elem['address'] = 'N/A' : $elem['address'] = $member->address;
      $member->city == NULL ? $elem['city'] = 'N/A' : $elem['city'] = $member->city;
      $member->state == NULL ? $elem['state'] = 'N/A' : $elem['state'] = $member->state;
      $member->zip == NULL ? $elem['zip'] = 'N/A' : $elem['zip'] = $member->zip;
      $elem['active'] = $member->active;
      $member->cur_year == NULL ? $elem['cur_year'] = 'N/A' : $elem['cur_year'] = $member->cur_year;
      $elem['mem_type'] = $member->mem_type;
      $elem['callsign'] = $member->callsign;
      $elem['license'] = $member->license;
      $elem['cur_year'] = $member->cur_year;
      $elem['hard_news'] = $member->hard_news;
      $elem['spouse_name'] = $member->spouse_name;
      $elem['spouse_call'] = $member->spouse_call;
      $elem['pay_date'] = date('Y-m-d', $member->paym_date);
      $elem['pay_date_file'] = date('Y/m/d', $member->paym_date);
      $elem['silent_date'] = date('Y-m-d', $member->silent_date);
      $member->mem_since == NULL ? $elem['mem_since'] = 'N/A' : $elem['mem_since'] = $member->mem_since;
      $member->email == NULL ? $elem['email'] = 'N/A' : $elem['email'] = $member->email;
      $elem['ok_mem_dir'] = $member->ok_mem_dir;
      $cur_yr = date('Y', time());
      $elem['silent_date'] = '';
      $elem['silent_year'] = $member->silent_year;
      $member->usr_type == 98 ? $elem['silent'] = TRUE : $elem['silent'] = FALSE;
    }
    else {
      $elem = NULL;
    }
    $retarr = array();
    $retarr['primary'] = $elem;
    return $retarr;
  }

  public function get_member_by_email($email) {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('email', $email);
    $retval = array();
    $retval['flag'] = FALSE;
    $retval['empty'] = FALSE;
    $cnt = $builder->countAllResults();
    if(($cnt > 0) && (strlen($email) > 0)) {
      $retval['flag'] = TRUE;
      $builder->resetQuery();
      $builder->where('email', $email);
      $mem_obj = $builder->get()->getRow();
      $retval['fname'] = $mem_obj->fname;
      $retval['lname'] = $mem_obj->lname;
      $retval['callsign'] = $mem_obj->callsign;
      $retval['phone'] = $mem_obj->w_phone;
      $retval['email'] = $email;
      $retval['city'] = $mem_obj->city;
      $retval['state'] = $mem_obj->state;
      $retval['zip'] = $mem_obj->zip;
      $retval['address'] = $mem_obj->address;
    }
    elseif(strlen($email) == 0) {
      $retval['empty'] = TRUE;
    }
    $db->close();
    return $retval;
  }

  public function update_mem($param) {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->resetQuery();
    $w_phone = $this->do_phone($param['w_phone']);
    $h_phone = $this->do_phone($param['h_phone']);
    $param['w_phone'] = $w_phone['phone'];
    $param['h_phone'] = $h_phone['phone'];
    $callsign_arr = $this->do_callsign($param);
    $param['callsign'] = $callsign_arr['callsign'];
    $email_arr = $this->do_email($param);
    $param['email'] = $email_arr['email'];
    $id = $param['id'];
    unset($param['id']);
    $builder->update($param, ['id_members' => $id]);
    $builder->resetQuery();
    $builder->where('id_members', $id);
    $mem_obj = $builder->get()->getRow();
    $id_usr = $mem_obj->id_users;
    if($id_usr != 0) {
      $usr_array = array(
        'fname' => $mem_obj->fname,
        'lname' => $mem_obj->lname,
        'callsign' => $mem_obj->callsign,
        'street' => $mem_obj->address,
        'email' => $mem_obj->email,
        'phone' => $mem_obj->w_phone
      );
      $builder = $db->table('users');
      $builder->resetQuery();
      $builder->update($usr_array, ['id_user' => $id_usr]);
    }

    $retarr = array();
    $retarr['msg'] = array();
    $retarr['flag'] = TRUE;
    $retarr['msg']['cell'] = NULL;
    if(!$w_phone['flag']) {
      $retarr['msg']['cell'] = 'Cell number entered in wrong format and was not saved.';
      $retarr['flag'] = FALSE;
    }
     $retarr['msg']['phone'] = NULL;
     if(!$h_phone['flag']) {
       $retarr['msg']['phone'] = 'Other phone number entered in wrong format and was not saved.';
       $retarr['flag'] = FALSE;
     }

    $retarr['msg']['email'] = NULL;
    if(!$email_arr['flag']) {
      $retarr['msg']['email'] = 'You entered an email that is already in database. Please, enter a different email.';
      $retarr['flag'] = FALSE;
    }

   $retarr['msg']['callsign'] = NULL;
   if(!$callsign_arr['flag']) {
     $retarr['msg']['callsign'] = 'You entered a callsign that is already in database.';
     $retarr['flag'] = FALSE;
   }

    return $retarr;
  }

  public function get_fam_mems($id) {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $db->close();
    $builder->where('id_users', $id);
    $retarr = array();
    $retarr['fam_mems'] = array();
    if($builder->countAllResults() > 0) {
      $builder->resetQuery();
      $builder->where('id_users', $id);
      $member = $builder->get()->getRow();
      $id_mem = $member->id_members;
      $builder->resetQuery();
      $builder->where('parent_primary', $id_mem);
      $res = $builder->get()->getResult();
      foreach($res as $mem) {
        $fam_mem = $this->get_fam_mem($mem->id_members);
        array_push($retarr['fam_mems'], $this->get_fam_mem($mem->id_members));
      }
    }
    count($retarr['fam_mems']) > 0 ? $retarr['fam_flag'] = TRUE : $retarr['fam_flag'] = FALSE;
    return $retarr;
  }

  public function get_fam_mem($id) {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('id_members', $id);
    $db->close();
    $elem = array();
    if($builder->countAllResults() > 0) {
      $builder->resetQuery();
      $builder->where('id_members', $id);
      $member = $builder->get()->getRow();
      $elem['id_members'] = $id;

  //set the true or false values for boolean db entries
      $elem['carrier'] = trim(strtoupper($member->hard_news));
      $elem['dir'] = trim(strtoupper($member->hard_dir));
      $elem['arrl'] =  trim(strtoupper($member->arrl_mem));
      $elem['mem_card'] = trim(strtoupper($member->mem_card));
      $member->h_phone == NULL ? $elem['h_phone'] = '000-000-0000' : $elem['h_phone'] = $member->h_phone;
      $member->w_phone == NULL ? $elem['w_phone'] = '000-000-0000' : $elem['w_phone'] = $member->w_phone;
      $member->comment == NULL ? $elem['comment'] = '' : $elem['comment'] = $member->comment;
      $elem['phone_unlisted'] = $member->h_phone_unlisted;
      $elem['cell_unlisted'] = $member->w_phone_unlisted;
      $elem['email_unlisted'] = $member->email_unlisted;
      $elem['fname'] = $member->fname;
      $elem['lname'] = $member->lname;
      $member->address == NULL ? $elem['address'] = 'N/A' : $elem['address'] = $member->address;
      $member->city == NULL ? $elem['city'] = 'N/A' : $elem['city'] = $member->city;
      $member->state == NULL ? $elem['state'] = 'N/A' : $elem['state'] = $member->state;
      $member->zip == NULL ? $elem['zip'] = 'N/A' : $elem['zip'] = $member->zip;
      $elem['active'] = $member->active;
      $member->cur_year == NULL ? $elem['cur_year'] = 'N/A' : $elem['cur_year'] = $member->cur_year;
      $elem['id_mem_types'] = $member->id_mem_types;
      $elem['mem_type'] = $member->mem_type;
      $elem['callsign'] = $member->callsign;
      $elem['license'] = $member->license;
      $elem['cur_year'] = $member->cur_year;
      $elem['hard_news'] = $member->hard_news;
      $elem['spouse_name'] = $member->spouse_name;
      $elem['spouse_call'] = $member->spouse_call;
      $elem['pay_date'] = date('Y-m-d', $member->paym_date);
      $elem['pay_date_file'] = date('Y/m/d', $member->paym_date);
      $elem['silent_date'] = date('Y-m-d', $member->silent_date);
      $elem['parent_primary'] = $member->parent_primary;
      $member->mem_since == NULL ? $elem['mem_since'] = 'N/A' : $elem['mem_since'] = $member->mem_since;
      $member->email == NULL ? $elem['email'] = 'N/A' : $elem['email'] = $member->email;
      $elem['ok_mem_dir'] = $member->ok_mem_dir;
      $cur_yr = date('Y', time());
      $elem['silent_date'] = '';
      $elem['silent_year'] = $member->silent_year;
      $member->usr_type == 98 ? $elem['silent'] = TRUE : $elem['silent'] = FALSE;
    }
    else {
      $elem = NULL;
    }
    return $elem;
  }

  public function add_fam_mem($param) {
    $retval = NULL;

    $dups = $this->check_dup($param);

    $flag = TRUE;

    if($dups['fam_mem']) {
      $retval = '<p class="text-danger fw-bold">This family member already exists in database. No data was saved</p>';
      $flag = FALSE;
    }

    if($dups['callsign']) {
      $retval == NULL ? $retval = '<p class="text-danger fw-bold">This callsign '. $param['callsign'] . ' already exists in database. No data was saved.</p>' : $retval .= '<p class="text-danger fw-bold">This callsign '. $param['callsign'] . ' already exists in database. No data was saved.';
      $flag = FALSE;
    }

    if($dups['email']) {
      $retval == NULL ? $retval = '<p class="text-danger fw-bold">This email '. $param['email'] . ' already exists in database. No data was saved.</p>' : $retval .= '<p class="text-danger fw-bold">This email '. $param['email'] . ' already exists in database. No data was saved.';
      $flag = FALSE;
    }

    if($flag) {
      $db      = \Config\Database::connect();
      $builder = $db->table('tMembers');
      $builder->resetQuery();
      $mem_array = array('id_mem_types' => 2, 'mem_type' => 'Primary');
      $builder->update($mem_array, ['id_members' => $param['parent_primary']]);
      $builder->resetQuery();
      $builder->where('id_members', $param['parent_primary']);
      $mem_obj = $builder->get()->getRow();
      $param['address'] = $mem_obj->address;
      $param['city'] = $mem_obj->city;
      $param['state'] = $mem_obj->state;
      $param['zip'] = $mem_obj->zip;
      $param['pay_date'] = $mem_obj->pay_date;
      $param['cur_year'] = $mem_obj->cur_year;
      $builder->resetQuery();
      $builder = $db->table('tMembers');
      $builder->resetQuery();
      $builder->insert($param);
      $db->close();
    }

    return $retval;
  }

  /**
  * Checks for duplicate family member and callsign
  */
  private function check_dup($param) {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('lname', $param['lname']);
    $builder->where('fname', $param['fname']);
    $builder->where('mem_type', $param['mem_type']);
    $builder->where('parent_primary', $param['parent_primary']);

    $retarr = array();

//check for duplicate family member
    $builder->countAllResults() > 0 ? $retarr['fam_mem'] = TRUE : $retarr['fam_mem'] = FALSE;

//check for duplicate callsign
    $retarr['callsign'] = FALSE;
    $sum = 0;
    if($param['callsign'] == '') {$sum++;}
    if(strtolower($param['callsign']) == 'none'){$sum++;}
    if(strtolower($param['callsign']) == 'swl'){$sum++;}

//if(($param['callsign'] != '') || (strtolower($param['callsign']) != 'none') || (strtolower($param['callsign']) != 'swl')) {
    if($sum == 0) {
      $builder->resetQuery();
      $builder->where('callsign', $param['callsign']);
      $builder->countAllResults() > 0 ? $retarr['callsign'] = TRUE : $retarr['callsign'] = FALSE;
    }

//check for duplicate email
    $retarr['email'] = FALSE;
    $builder->resetQuery();
    $builder->where('email', $param['email']);
    $builder->where('parent_primary!=', $param['parent_primary']);
    $builder->where('id_members!=', $param['parent_primary']);
    $builder->countAllResults() > 0 ? $retarr['email'] = TRUE : $retarr['email'] = FALSE;

    return $retarr;
  }

/**
* Checks for second duplicate family member when editing
* The difference from the ordinary check_dup is
* the check for the callsign where id != id_members
* and count results are > 1
*/
  private function check_second_dup($param) {

    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('lname', $param['lname']);
    $builder->where('fname', $param['fname']);
    $builder->where('mem_type', $param['mem_type']);
    $builder->where('parent_primary', $param['parent_primary']);

    $retarr = array();

//check for duplicate family member
    $builder->countAllResults() > 1 ? $retarr['fam_mem'] = TRUE : $retarr['fam_mem'] = FALSE;

//check for duplicate callsign
    $retarr['callsign'] = FALSE;
    $sum = 0;
    if($param['callsign'] == '') {$sum++;}
    if(strtolower($param['callsign']) == 'none'){$sum++;}
    if(strtolower($param['callsign']) == 'swl'){$sum++;}

//if(($param['callsign'] != '') || (strtolower($param['callsign']) != 'none') || (strtolower($param['callsign']) != 'swl')) {
    if($sum == 0) {
      $builder->resetQuery();
      $builder->where('callsign', $param['callsign']);
      $builder->where('id_members!=', $param['id']);
      $builder->countAllResults() > 0 ? $retarr['callsign'] = TRUE : $retarr['callsign'] = FALSE;
    }

//check for duplicate email
        $retarr['email'] = FALSE;
        $builder->resetQuery();
        $builder->where('email', $param['email']);
        $builder->where('parent_primary!=', $param['parent_primary']);
        $builder->where('id_members!=', $param['parent_primary']);
        $builder->countAllResults() > 0 ? $retarr['email'] = TRUE : $retarr['email'] = FALSE;

    return $retarr;
  }

  public function edit_fam_mem($param) {

    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('id_members', $param['id']);
    $mem = $builder->get()->getRow();

    $orig_mem = $this->get_fam_mem($param['id']);

    $id = $param['id'];
    unset($param['id']);

    $builder->resetQuery();
    $builder->update($param, ['id_members' => $id]);
    $param['id'] = $id;

// Check for dup entry (need parent_primary for that)
    $param['parent_primary'] = $mem->parent_primary;
    $param['id'] = $id;
    $dups = $this->check_second_dup($param);

    $flag = TRUE;
    $retval = '';

    if($dups['fam_mem']) {
      $retval = 'This family member already exists in database.';
      $flag = FALSE;
    }

    if($dups['callsign']) {
      $retval == NULL ? $retval = '<br>This callsign '. $param['callsign'] . ' already exists in database. No data was saved.' : $retval .= '<br>This callsign '. $param['callsign'] . ' already exists in database. No data was saved.';
      $flag = FALSE;
    }

    if($dups['email']) {
      $retval == NULL ? $retval = '<br>This email '. $param['email'] . ' already exists in database. No data was saved.' : $retval .= '<br>This email '. $param['email'] . ' already exists in database. No data was saved.';
      $flag = FALSE;
    }

// In case we have exact duplicate fam member or duplicate callsign roll the changes back to the original
    if(!$flag) {
      $id = $param['id'];
      unset($orig_mem['id']);
      unset($orig_mem['carrier']);
      unset($orig_mem['dir']);
      unset($orig_mem['arrl']);
      unset($orig_mem['phone_unlisted']);
      unset($orig_mem['pay_date_file']);
      unset($orig_mem['silent']);
      $builder->resetQuery();
      $builder->update($orig_mem, ['id_members' => $id]);
    }

    $db->close();
    return $retval;
  }

  public function delete_fam_mem($id) {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('id_members', $id);
    $id_prim = $builder->get()->getRow()->parent_primary;
    $builder->resetQuery();
    $builder->where('id_members', $id_prim);
    $id_usr = $builder->get()->getRow()->id_users;
    $builder->resetQuery();
    $builder = $db->table('tMembers');
    $builder->where('id_members', $id);
    $builder->delete(['id_members' => $id]);
    $fams = $this->get_fam_mems($id_usr);
    if(!$fams['fam_flag']) {
      $builder->resetQuery();
      $param = array('id_mem_types' => 1, 'mem_type' => 'Individual');
      $builder->update($param, ['id_members' => $id_prim]);
    }
  }

  public function do_email($param) {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('id_members!=', $param['id']);
    $builder->where('parent_primary!=', $param['id']);
    $builder->where('email', $param['email']);
    $retarr = array();
    if($builder->countAllResults() > 0) {
      $builder->resetQuery();
      $builder->where('id_members', $param['id']);
      $retarr['email'] = $builder->get()->getRow()->email;
      $retarr['flag'] = FALSE;
    }
    else {
      $retarr['email'] = $param['email'];
      $retarr['flag'] = TRUE;
    }
    $db->close();
    return $retarr;
  }

  public function do_callsign($param) {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('id_members!=', $param['id']);
    $builder->where('callsign', $param['callsign']);
    $retarr = array();
    if($builder->countAllResults() > 0) {
      $builder->resetQuery();
      $builder->where('id_members', $param['id']);
      $retarr['callsign'] = $builder->get()->getRow()->callsign;
      $retarr['flag'] = FALSE;
    }
    else {
      $retarr['callsign'] = $param['callsign'];
      $retarr['flag'] = TRUE;
    }
    $db->close();
    return $retarr;
  }

  /**
  * Converts number string into phone format
  * Inspired by: https://www.geeksforgeeks.org/how-to-format-phone-numbers-in-php/
  * - that didn't work!!!
  * Instead the second option: https://www.delftstack.com/howto/php/php-format-phone-number/
  */
    public function do_phone($phone) {
      $number = preg_replace("/[^0-9]/", "", $phone);
      $retarr = array();
      $retarr['phone'] = "";
      $retarr['flag'] = TRUE;
      //echo '<br><br><br><br>';
      if(strlen($number) == 11) {
        $retarr['phone'] = sprintf("%s-%s-%s",
            substr($number, 1, 3),
            substr($number, 4, 3),
            substr($number, 7));
      }
      elseif(strlen($number) == 10) {
        $retarr['phone'] = sprintf("%s-%s-%s",
            substr($number, 0, 3),
            substr($number, 3, 3),
            substr($number, 6));
      }
      else{
        $retarr['flag'] = FALSE;
      }
      return $retarr;
    }
}
