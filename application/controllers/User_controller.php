<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_controller extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url','cookie','string'));
    }

    private function if_login_redirect() {
        if($this->session->userdata('login')) {
            $this->session->set_flashdata('msg',array('status'=>'danger','title'=>'Access Denied','text'=>'You already logged in'));
                redirect("https://ci.jaegyu.com");
        }
    }

    /* login */
    public function login_index()
    {
        $this->if_login_redirect();
        $this->load->database();
        $this->load->model('user_model');

        /* auto login */
        if(get_cookie('ci_auto_login')) {
            $user = $this->user_model->get_with_email(unserialize(get_cookie('ci_auto_login'))['email']);
            
            if(password_verify($user->_id,unserialize(get_cookie('ci_auto_login'))['id'])) {
                $this->session->set_userdata('login',$user);
                redirect("https://ci.jaegyu.com");
            }            
        }

		$this->load->view("layouts/header");
		$this->load->view('login');
		$this->load->view("layouts/footer");

	}

	public function login()
    {
        $this->if_login_redirect();
        $this->load->library('form_validation');
        $this->load->model('user_model');

        /* login */ 
        $this->form_validation->set_rules('email','Email','required|valid_email',
            array('required' => '%s field is required',
                'valid_email' => '%s field is not valid'));
        $this->form_validation->set_rules('password','Password','required',
            array('required' => '%s field is required'));

        if ($this->form_validation->run() == FALSE) {
            $this->load->view("layouts/header");
            $this->load->view('login');
            $this->load->view("layouts/footer");
        }else {            
            $user = $this->user_model->get($this->input->post('email'));

            if(($user->email == $this->input->post('email')) && password_verify($this->input->post('password'),$user->password)) {
                $this->session->set_userdata('login',$user);
                if($this->input->post('remember')) {
                    $cookie = array(
                        'name' => 'ci_auto_login',
                        'value' => serialize(array(
                            'id' => password_hash($user->_id,PASSWORD_BCRYPT),
                            'email' => $this->input->post('email')
                        )),
                        'expire' => 2147483647,
                        'domain' => '.jaegyu.com',
                        'path' => '/'
                    );

                    set_cookie($cookie);
                    redirect("https://ci.jaegyu.com");
                }else {
                    redirect("https://ci.jaegyu.com");                  
                }
            }else { // failed
                $this->session->set_flashdata('msg',array('status'=>'danger','title'=>'Failed','text'=>'Sign In Failed'));
                $this->load->view("layouts/header");
                $this->load->view('login');
                $this->load->view("layouts/footer");
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        delete_cookie('ci_auto_login', '.jaegyu.com', '$path'); 
        redirect("https://ci.jaegyu.com");
    }

	/* register */
    public function register_index()
    {
        $this->if_login_redirect();
        $this->load->view("layouts/header");
        $this->load->view('register');
        $this->load->view("layouts/footer");
    }

    public function register()
    {
        $this->if_login_redirect();
        $this->load->library('form_validation');
        $this->load->model('user_model');

        $this->form_validation->set_rules('name', 'Name', 'required|max_length[10]',
            array('required' => '%s field is required',
                  'max_length' => '%s field is too long, 10 characters max'));
        $this->form_validation->set_rules('email','Email','required|is_unique[tb_users.email]|valid_email',
            array('required' => '%s field is required',
                  'is_unique' => 'This email is already exists',
                  'valid_email' => '%s field is not valid'));
        $this->form_validation->set_rules('password','Password','required',
            array('required' => '%s field is required'));
        $this->form_validation->set_rules('password_confirm','Password Confirm','required|matches[password]',
            array('required' => '%s field is required',
                  'matches' => 'The password and password confirmation do not match'));

        if ($this->form_validation->run() == FALSE) {
            $this->load->view("layouts/header");
            $this->load->view('register');
            $this->load->view("layouts/footer");
        }
        else {

            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

            $r = $this->user_model->insert($name,$email,$password);
            if($r != null) {
                $this->session->set_flashdata('msg',array('status'=>'success','title'=>'Success','text'=>'Create Account Success!'));
                redirect("https://ci.jaegyu.com/login");
            }else {
                $this->session->set_flashdata('msg',array('status'=>'danger','title'=>'Failed','text'=>'Create Account Failed'));
                redirect("https://ci.jaegyu.com/register");
            }
        }


    }

    /* forgot password */
    public function forgot_index() {
        $this->if_login_redirect();
        $this->load->view("layouts/header");
        $this->load->view('forgot');
        $this->load->view("layouts/footer");
    }

    public function forgot() {
        $this->if_login_redirect();
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->database();
        $this->load->model('user_model');
        $this->load->model('reset_password_token_model');
        
        $data['email_value'] = $this->input->post('email');

        $check = $this->user_model->get_with_email($this->input->post('email'));

        if((count($check) == 0)) {
            $this->session->set_flashdata('msg',array('status'=>'danger','title'=>'Failed','text'=>'No user with the specified email exist'));
            $this->load->view("layouts/header");
            $this->load->view('forgot');
            $this->load->view("layouts/footer");
            
        }else {
            $this->email->from('master@jaegyu.com','Master');
            $this->email->to($this->input->post('email'));
            $this->email->set_mailtype("html");
            $this->email->subject('Reset your password');
            $hash = random_string("sha1");
            $message = 'https://ci.jaegyu.com/reset_password/'.$hash;
            $this->email->message("<a href = '".$message."'>".$message."</a>");
            $this->email->send();
            $this->email->clear();

            $this->reset_password_token_model->insert($hash,$check->_id);

            $this->load->view("layouts/header");
            $this->load->view('forgot',$data);
            $this->load->view("layouts/footer");
        }

    }

    /* reset password */
    public function reset_password_index($email) {
        $this->if_login_redirect();
        $data['email_hash'] = $email;
        $this->load->view("layouts/header");
        $this->load->view('reset_password',$data);
        $this->load->view("layouts/footer");
    }

    public function reset_password($email) {
        $this->if_login_redirect();
        $data['email_hash'] = $email;
        $this->load->library('form_validation');

        $this->form_validation->set_rules('password','Password','required',
            array('required' => '%s field is required'));
        $this->form_validation->set_rules('password_confirm','Password Confirm','required|matches[password]',
            array('required' => '%s field is required',
                  'matches' => 'The password and password confirmation do not match'));

        if ($this->form_validation->run() == FALSE) {
            $this->load->view("layouts/header");
            $this->load->view('reset_password',$data);
            $this->load->view("layouts/footer");
        }else {
            $this->load->database();
            $this->load->model('user_model');
            $this->load->model('reset_password_token_model');

            if($user = $this->user_model->get_with_id($this->reset_password_token_model->get_with_token($email))) {
                $this->user_model->change_password(password_hash($this->input->post('password'),PASSWORD_BCRYPT),$user->_id);

                $this->reset_password_token_model->delete($email);

                $this->session->set_flashdata('msg',array('status'=>'success','title'=>'Success','text'=>'Change password success!'));
                redirect("https://ci.jaegyu.com/login");
            }else {
                $this->session->set_flashdata('msg',array('status'=>'danger','title'=>'Failed','text'=>'Not invaild token'));
                redirect("https://ci.jaegyu.com/login");
            }
            
        }
    }
}