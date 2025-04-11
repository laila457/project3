<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Auth_api extends RestController {

    function __construct() {
        parent::__construct();
        $this->load->database(); // ✅ WAJIB untuk pakai $this->db
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function register_post() {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => FALSE,
                'message' => validation_errors()
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            // ✅ Cek manual apakah email sudah terdaftar
            $email = $this->input->post('email');
            $existing = $this->db->get_where('users', ['email' => $email])->row();

            if ($existing) {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Email sudah terdaftar'
                ], RestController::HTTP_BAD_REQUEST);
                return;
            }

            // Simpan user baru
            $data = [
                'name'     => $this->input->post('name'),
                'email'    => $email,
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            ];

            if ($this->User_model->register($data)) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'User berhasil didaftarkan'
                ], RestController::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Gagal mendaftarkan user'
                ], RestController::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function login_post() {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => FALSE,
                'message' => validation_errors()
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->getUserByEmail($email);

            if ($user && password_verify($password, $user->password)) {
                $token = bin2hex(random_bytes(32)); // Token random

                // Simpan ke session
                $this->session->set_userdata([
                    'user_id' => $user->id,
                    'token'   => $token
                ]);

                $this->response([
                    'status' => TRUE,
                    'message' => 'Login berhasil',
                    'data' => [
                        'user_id' => $user->id,
                        'name'    => $user->name,
                        'email'   => $user->email,
                        'token'   => $token
                    ]
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Email atau password salah'
                ], RestController::HTTP_UNAUTHORIZED);
            }
        }
    }
}
