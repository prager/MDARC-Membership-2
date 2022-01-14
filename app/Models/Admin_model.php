<?php namespace App\Models;

use CodeIgniter\Model;
/**
* This model is for special functions for Master user
*/
class Admin_model extends Model {

  var $db;

  public function __construct()  {
        parent::__construct();
  }
/**
* Gets user types and puts them into csv file
*/
public function put_user_types() {
  $db      = \Config\Database::connect();
  $builder = $db->table('user_types');
  $res = $builder->get()->getResult();
  $types_str = "id,type code,description,code string,controller\n";
  foreach($res as $type) {
    $types_str .= $type->id_user_types.",".$type->type_code.",".$type->description.",".$type->code_str.",".$type->controller."\n";
  }
  file_put_contents('files/user_types.csv', $types_str);
  $db->close();
}

/**
* Gets users and puts them into csv file
*/
  public function put_users() {
    $db      = \Config\Database::connect();
    $builder = $db->table('users');
    $res = $builder->get()->getResult();
    $users_str = "id,type code,role,username,authorized,active\n";
    foreach($res as $user) {
      $users_str .= $user->id_user.",".$user->type_code.",".$user->role.",".$user->username.",".$user->authorized.",".$user->active."\n";
    }
    file_put_contents('files/users.csv', $users_str);
    $db->close();
  }

  /**
  * Gets data for displaying master_view
  * @return string array $retval
  */
  public function get_users_data() {
    $db      = \Config\Database::connect();
    $builder = $db->table('users');
    $res = $builder->get()->getResult();
    $usr_types = $this->get_user_types();
    $users = array();
    foreach($res as $user) {
      if($user->type_code != 99) {
        $usr_arr = array(
          'id' => $user->id_user,
          'fname' => $user->fname,
          'lname' => $user->lname,
          'callsign' => $user->callsign,
          'active' => $user->active,
          'authorized' => $user->authorized,
          'usr_types' => $usr_types,
          'street' =>$user->street,
          'city' => $user->city,
          'state' => $user->state_cd,
          'zip' => $user->zip_cd,
          'phone' => $user->phone,
          'email' => $user->email
        );
        $user->username != NULL ? $usr_arr['username'] = $user->username : $usr_arr['username'] = 'Not Set!';
        $user->id_user_type != 0 ? $usr_arr['type_desc'] = $usr_types[$user->id_user_type] : $usr_arr['type_desc'] = $usr_types[2];
        $user->id_user_type == 0 ? $usr_arr['type_code'] = 4 : $usr_arr['type_code'] = $user->id_user_type;
        $user->comment == NULL ? $usr_arr['comment'] = '' : $usr_arr['comment'] = $user->comment;
        $user->facebook == NULL ? $usr_arr['facebook'] = '' : $usr_arr['facebook'] = $user->facebook;
        $user->twitter == NULL ? $usr_arr['twitter'] = '' : $usr_arr['twitter'] = $user->twitter;
        $user->linkedin == NULL ? $usr_arr['linkedin'] = '' : $usr_arr['linkedin'] = $user->linkedin;
        $user->comment == NULL ? $usr_arr['comment'] = '' : $usr_arr['comment'] = $user->comment;
        $user->city == NULL ? $usr_arr['city'] = '' : $usr_arr['city'] = $user->city;
        $user->zip_cd == NULL ? $usr_arr['zip'] = '' : $usr_arr['zip'] = $user->zip_cd;
        array_push($users, $usr_arr);
      }
    }
    $db->close();
    return array('users' => $users);
  }

  private function get_user_types() {
    $db      = \Config\Database::connect();
    $builder = $db->table('admin_types');
    $res = $builder->get()->getResult();
    $types_arr = array();
    foreach($res as $type) {
        $types_arr[$type->id_user_types] = $type->description;
    }
    return $types_arr;
  }

  private function get_user_type($id) {
    $id != 0 ? $retval = $id : $retval = 4;
    return $retval;
  }

  public function delete_user($id) {
    $db      = \Config\Database::connect();
    $builder = $db->table('users');
    $db->close();
    $builder->delete(['id_user' => $id]);
  }

  public function load_admin($param) {
    $db      = \Config\Database::connect();
    $builder = $db->table('users');
    $id = $param['id_user'];
    unset($param['id_user']);
    $builder->resetQuery();
    $builder->update($param, ['id_user' => $id]);
    $builder->resetQuery();
    $builder = $db->table('tMembers');
    $builder->where('fname', $param['fname']);
    $builder->where('lname', $param['lname']);
    if($builder->countAllResults() > 0) {
      $builder->resetQuery();
      $builder->where('fname', $param['fname']);
      $builder->where('lname', $param['lname']);
      $id_mem = $builder->get()->getRow()->id_members;
      $builder->resetQuery();
      //echo 'id mem: ' . $id_mem . '<br>';
      //echo 'id usr: ' . $id;
      $arr = array('id_users' => $id, 'usr_type' => $param['type_code']);
      $builder->update($arr, ['id_members' => $id_mem]);
    }
    $db->close();
  }

  public function activate($id) {
    $db      = \Config\Database::connect();
    $builder = $db->table('users');
    $db->close();
    $builder->where('id_user', $id);
    $flag = $builder->get()->getRow()->active;
    if($flag == 1) {
      $builder->resetQuery();
      $builder->update(array('active' => 0), ['id_user' => $id]);
    }
    else {
      $builder->resetQuery();
      $builder->update(array('active' => 1), ['id_user' => $id]);
    }
  }

  public function authorize($id) {
    $db      = \Config\Database::connect();
    $builder = $db->table('users');
    $builder->where('id_user', $id);
    $usr = $builder->get()->getRow();
    $flag = $usr->authorized;
    if($flag == 1) {
      $builder->resetQuery();
      $builder->update(array('authorized' => 0), ['id_user' => $id]);
    }
    else {
      $builder->resetQuery();
      $builder->update(array('authorized' => 1), ['id_user' => $id]);

      /*$subject = 'MDARC Portal: You Are Now Authorized Access';
      $message = $usr->fname . ' ' . $usr->lname . "\n\n".
 	        'You are now authorized to access MDARC membership portal at ' . base_url() . '. Thank you!';
 	    mail($usr->email, $subject, $message);

      $subject = 'MDARC Portal: User Authorization';
      $message = $usr->fname . ' ' . $usr->lname . "\n\n".
 	        'Was just authorized to use MDARC membership portal.';
      mail('jkulisek.us@gmail.com', $subject, $message);*/
    }
    $builder->resetQuery();
    $builder = $db->table('tMembers');
    $builder->where('email', $usr->email);
    if($builder->countAllResults() > 0) {
      $builder->resetQuery();
      $builder = $db->table('tMembers');
      $builder->where('email', $usr->email);
      $id_mem = $builder->get()->getRow()->id_members;
      $builder->resetQuery();
      $builder = $db->table('tMembers');
      $builder->update(array('id_users' => $id), ['id_members' => $id_mem]);
    }
    $db->close();
  }

  public function reset_user($param) {
    $db      = \Config\Database::connect();
    $builder = $db->table('users');
    $db->close();

    $retarr = array();

    $retarr['pass_match'] = TRUE;
    $retarr['pass_comp'] = TRUE;
    $retarr['flag'] = TRUE;
    $retarr['usr_dup'] = FALSE;

//check password complexity
    if($param['pass'] != $param['pass2'] && preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,12}$/', $param['pass'])) {
      $retarr['pass_comp'] = FALSE;
      $retarr['flag'] = FALSE;
    }

//check if passwords match
    if($param['pass'] != $param['pass2']) {
      $retarr['pass_match'] = FALSE;
      $retarr['flag'] = FALSE;
    }

//if not flagged and all good then update username and password
    if($retarr['flag']) {
      $param['username'] = strtolower($param['username']);
      $param['pass'] = password_hash($param['pass'], PASSWORD_BCRYPT, array('cost' => 12));
      $update = array('pass' => $param['pass'], 'username' => $param['username'], 'active' => 1);
      $builder->update($update, ['id_user' => $param['id_user']]);
    }

    return $retarr;
  }
}
