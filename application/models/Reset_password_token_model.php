<?php
class Reset_password_token_model extends CI_Model {

    public $id;
    public $token;
    public $user_id;

    public function insert($token,$user_id)
    {
        if($this->db->get_where('reset_password_token',array('user_id' => $user_id))) {
            $this->db->delete('reset_password_token', array('user_id' => $user_id));   
        }

        $this->db->set('token', $token);
        $this->db->set('user_id', $user_id);
        $this->db->insert('reset_password_token');

        return $this->db->insert_id();
    }

    public function delete($token) {
        $this->db->delete('reset_password_token', array('token' => $token));   
    }

    public function get_with_token($token) {
        $r = $this->db->get_where('reset_password_token',array('token' => $token))->row();
        return $r->user_id;
    }

}