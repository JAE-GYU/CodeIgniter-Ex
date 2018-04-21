<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_controller extends CI_Controller 
{
	public function index() 
	{							
		$this->load->view("layouts/header");
		$this->load->view('main');
		$this->load->view("layouts/footer");	
	}

	public function loadData() {
		$this->load->database();
		$this->load->model('board_model');
		$this->load->model('user_model');

		/* pagination */
		if($this->input->get('page')) {
			$page = $this->input->get('page');
		}else {
			$page = 1;
		}

		if($page <= 1) {
			$page = 1;
		}


		$max_page = ceil($this->db->count_all('tb_board')/10);	

		$board = array();
		$this->db->from('tb_board');
		$this->db->order_by('updated_at','DESC');
		$this->db->limit(10,($page -1) * 10);		
		$query = $this->db->get();			


		foreach ($query->result() as $row)
		{
			array_push($board,[
				'_id' => $row->_id,
				'name' => $this->user_model->get_with_id($row->user_id)->name,
				'title' => $row->title,
				'content' => $row->content,
				'image' => $row->image,
				'created_at' => $row->created_at]);
		}

		$this->load->view('page',array('board'=>$board));	
	}
}