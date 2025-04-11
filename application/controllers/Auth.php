<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index() {
        $this->load->view('auth/login');
    }

    public function login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // Add your authentication logic here
        if($email && $password) {
            redirect('home');
        } else {
            redirect('auth?error=1');
        }
    }

    public function register() {
        // Add registration logic here
        $this->load->view('auth/register');
    }
}