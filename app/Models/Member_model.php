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
    $id = $param['id'];
    unset($param['id']);
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->resetQuery();
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
    return $elem;
  }

  public function add_fam_mem($param) {
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
    $builder->resetQuery();
    $builder = $db->table('tMembers');
    $builder->resetQuery();
    $builder->insert($param);
    $db->close();
  }

  public function edit_fam_mem($param) {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $id = $param['id'];
    unset($param['id']);
    $builder->resetQuery();
    $builder->update($param, ['id_members' => $id]);
  }

  public function delete_fam_mem($id) {
    $db      = \Config\Database::connect();
    $builder = $db->table('tMembers');
    $builder->where('id_members', $id);
    $id_prim = $builder->get()->getRow()->parent_primary;
    $builder->resetQuery();
    $param = array('id_mem_types' => 1, 'mem_type' => 'Individual');
    $builder->update($param, ['id_members' => $id_prim]);
    $builder->resetQuery();
    $builder->delete(['id_members' => $id]);
  }

}
