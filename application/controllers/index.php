<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class index extends CI_Controller {
	public function index()
	{
		$this->load->view('index');
	}
    public function layanan()
	{
		$this->load->view('layanan');
	}
	public function login()
	{
		$this->load->view('login');
	}
}
