<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model {
public function register($data)
{
   return $this->db->insert('users', $data);
}
public function getUserByEmail($email)
{
return $this->db->where('email', $email)->get('users')->row();
}
public function getUserById($id)
{
return $this->db->where('id', $id)->get('users')->row();
}
}