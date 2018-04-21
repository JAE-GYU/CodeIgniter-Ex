<?php
class Board_model extends CI_Model {

    public $id;
    public $title;
    public $content;
    public $user_id;
    public $image;
    public $created_at;
    public $updated_at;

    public function getAll() {
        return $this->db->get('tb_board')->row();
    }

    public function get_with_id($id) {
        $result = $this->db->get_where('tb_board',array('_id' => $id));
        return $result->row();
    }

    public function insert($title,$content,$user_id,$image) {
        $this->db->set('title',$title);
        $this->db->set('content',$content);
        $this->db->set('user_id',$user_id);
        $this->db->set('image',$image);
        $this->db->set('created_at','now()',false);
        $this->db->set('updated_at','now()',false);

        $this->db->insert('tb_board');

        return $this->db->insert_id();
    }

    public function update($id,$title,$content,$image) {
        $this->db->set('title',$title);
        $this->db->set('content',$content);
        if($image != "") {        
            $this->db->set('image',$image);
        }
        $this->db->set('updated_at','now()',false);
        $this->db->where("_id",$id);
        $this->db->update('tb_board');
        return $id;
    }

    public function delete($id) {
        $this->db->where('_id',$id);
        $this->db->delete('tb_board');
    }
}