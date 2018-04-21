<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board_controller extends CI_Controller 
{

	public function ___construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}
	
	private function if_login_redirect() {
		$this->load->helper('url');
        if(!$this->session->userdata('login')) {
        	redirect("https://ci.jaegyu.com/login");
        }
    }

    /* view */
    public function view($board_num)
    {
    	$this->load->database();
    	$this->load->model('user_model');
    	$this->load->model('board_model');
    	$board = $this->board_model->get_with_id($board_num);

    	if(!isset($board)) {
    		$this->load->view("layouts/header");    		
    		$this->load->view("view_error");    		
			$this->load->view("layouts/footer");	
    	}else {
    		$board->name = $this->user_model->get_with_id($board->user_id)->name;
    		$board->image = str_replace("/thumbnail", "", $board->image);

    		$this->load->view("layouts/header");		    	
    		$this->load->view("board_view",array('board' => $board));		    	
			$this->load->view("layouts/footer");	
    	}    	
    }

    /* download image */
    public function download($board_num)
    {
    	$this->load->database();
    	$this->load->model('user_model');
    	$this->load->model('board_model');
    	$this->load->helper('download');

    	$board = $this->board_model->get_with_id($board_num);

    	if(!isset($board)) {
    		$this->load->view("layouts/header");    		
    		$this->load->view("view_error");    		
			$this->load->view("layouts/footer");	
    	}else {    		
    		$board->image = str_replace("/thumbnail", "", $board->image);
    		$data = file_get_contents($_SERVER['DOCUMENT_ROOT'].$board->image);
    		$file_name = str_replace("/uploads/", "", $board->image);

    		force_download($file_name, $data);
    	}    	
    }
    
    /* update */
    public function update_view($id) {
    	$this->load->database();
    	$this->load->helper('url');
    	$this->load->library('form_validation');	
    	$this->load->model('user_model');
    	$this->load->model('board_model');

    	$board = $this->board_model->get_with_id($id);    	
		
		if(!$this->session->userdata('login')) {
			$this->session->set_flashdata('msg',array('status'=>'danger','title'=>'Access Denied','text'=>'Need Sign In'));
    		redirect("https://ci.jaegyu.com/login");
    	}
    	else if($this->session->userdata('login')->_id != $board->user_id) {
    		$this->session->set_flashdata('msg',array('status'=>'danger','title'=>'Access Denied','text'=>'No Permission'));
            redirect("https://ci.jaegyu.com/view/".$id);
    	}
    	
    	$this->load->view("layouts/header");    		
		$this->load->view("update",array('board'=>$board));    		
		$this->load->view("layouts/footer");
    }

    public function update($id) {
    	$this->if_login_redirect();
		$this->load->database();
		$this->load->model('user_model');		
		$this->load->model('board_model');		
		$title = $this->input->post('title');
		$content = $this->input->post('content');
		$user_id = $this->session->userdata('login')->_id;
		
		if(isset($_FILES['img'])) {
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png';		
			

			$this->load->library('upload', $config);
		
			if ( ! $this->upload->do_upload('img'))
			{				
				$img_name = "";
			}	
			else
			{															
				$img_name = $this->upload->data()['file_name'];
				$full_path = $this->upload->data()['full_path'];
				chmod($full_path, 0777);

				$this->load->library('image_lib');
				$config['image_library'] = 'gd2';
				$config['source_image']	= $_SERVER['DOCUMENT_ROOT']."/uploads/".$img_name;
				$config['maintain_ratio'] = TRUE;				
				$config['width'] = "200";
				$config['new_image'] = $_SERVER['DOCUMENT_ROOT']."/uploads/thumbnail/".$img_name;
				$this->image_lib->initialize($config);
				$this->image_lib->resize();

				$img_name =  "/uploads/thumbnail/".$img_name;

			}


		}else {
			$img_name = "";
		}


		$r = $this->board_model->update($id,$title,$content,$img_name);

		if($r != null) {
			echo "success";
		}else {
			echo "failed";			
		}
    }

    /* delete */
    public function delete($id) {
    	$this->load->database();
    	$this->load->helper('url');
    	$this->load->model('user_model');
    	$this->load->model('board_model');

    	$board = $this->board_model->get_with_id($id);    	
		
		if(!$this->session->userdata('login')) {
			$this->session->set_flashdata('msg',array('status'=>'danger','title'=>'Access Denied','text'=>'Need Sign In'));
    		redirect("https://ci.jaegyu.com/login");
    	}
    	else if($this->session->userdata('login')->_id != $board->user_id) {
    		$this->session->set_flashdata('msg',array('status'=>'danger','title'=>'Access Denied','text'=>'No Permission'));
            redirect("https://ci.jaegyu.com/view/".$id);
    	}

    	$this->board_model->delete($id);
    	$this->session->set_flashdata('msg',array('status'=>'success','title'=>'Success','text'=>'Delete Success'));
        redirect("https://ci.jaegyu.com");
    }

    /* upload */
	public function upload_index() 
	{
		$this->if_login_redirect();
		$this->load->helper(array('form', 'url'));


		$this->load->view("layouts/header");
		$this->load->view('upload');
		$this->load->view("layouts/footer");	
	}

	public function upload() {
		$this->if_login_redirect();
		$this->load->database();
		$this->load->model('user_model');		
		$this->load->model('board_model');		
		$title = $this->input->post('title');
		$content = $this->input->post('content');
		$user_id = $this->session->userdata('login')->_id;
		
		if(isset($_FILES['img'])) {
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png';		
			

			$this->load->library('upload', $config);
		
			if ( ! $this->upload->do_upload('img'))
			{				
				$img_name = "";
			}	
			else
			{															
				$img_name = $this->upload->data()['file_name'];
				$full_path = $this->upload->data()['full_path'];
				chmod($full_path, 0777);

				$this->load->library('image_lib');
				$config['image_library'] = 'gd2';
				$config['source_image']	= $_SERVER['DOCUMENT_ROOT']."/uploads/".$img_name;
				$config['maintain_ratio'] = TRUE;				
				$config['width'] = "200";
				$config['new_image'] = $_SERVER['DOCUMENT_ROOT']."/uploads/thumbnail/".$img_name;
				$this->image_lib->initialize($config);
				$this->image_lib->resize();

				$img_name =  "/uploads/thumbnail/".$img_name;

			}


		}else {
			$img_name = "";
		}


		$r = $this->board_model->insert($title,$content,$user_id,$img_name);

		if($r != null) {
			echo "success";
		}else {
			echo "failed";			
		}

	}
}