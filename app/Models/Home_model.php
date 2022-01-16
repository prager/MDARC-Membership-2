<?php namespace App\Models;

use CodeIgniter\Model;

class Home_model extends Model {

  var $db;

  public function __construct()  {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function contact($param) {
    $flag = TRUE;
    
     if (!filter_var($param['email'], FILTER_VALIDATE_EMAIL)) {
       $flag = FALSE;
     }
     else {
       $recipient = 'leho@email.com';
       $subject = 'MDARC Mem Message';
       $message = $param['fname'] . ' ' . $param['lname'] . "\n\n". $param['email'] . "\n\n" .$param['msg'];
  	   mail($recipient, $subject, $message);
     }
     return $flag;
    }

}
