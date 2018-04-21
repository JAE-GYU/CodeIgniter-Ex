<?php
class User_model extends CI_Model {

    public $id;
    public $name;
    public $email;
    public $password;

    public function insert($name,$email,$password)
    {
        $this->db->set('name', $name);
        $this->db->set('email', $email);
        $this->db->set('password',$password);
        $this->db->set('reg_date','NOW()',FALSE);
        $this->db->insert('tb_users');

        return $this->db->insert_id();
    }

    public function change_password($password,$user_id) {
        $this->db->where('_id',$user_id);
        $this->db->update('tb_users',array('password' => $password));
    }

    public function get($email)
    {
        $result = $this->db->get_where('tb_users', array('email'=>$email))->row();
        return $result;
    }

    public function get_with_email($email) {
        $result = $this->db->get_where('tb_users',array('email'=>$email))->row();
        return $result;
    }

    public function get_with_id($id) {
        $result = $this->db->get_where('tb_users',array('_id'=>$id))->row();
        return $result;
    }
}