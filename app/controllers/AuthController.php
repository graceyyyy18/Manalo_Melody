<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->call->library('session');
        $this->call->library('form_validation');
        $this->call->model('StudentsModel');
    }

    /** ---------------- LOGIN ---------------- */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validation rules
            $this->form_validation->name('email')->required()->valid_email()->max_length(100);
            $this->form_validation->name('password')->required()->min_length(3)->max_length(50);

            if ($this->form_validation->run()) {
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);

                $user = $this->StudentsModel->find_by_email($email);

                if ($user && (
                        password_verify($password, $user['password'])   // ✅ hashed password
                        || $password === $user['password']             // fallback: plain (old DB)
                )) {
                    // Save user session
                    $this->session->set_userdata('logged_in', true);
                    $this->session->set_userdata('user_id', $user['id']);
                    $this->session->set_userdata('role', $user['role']);
                    $this->session->set_userdata('first_name', $user['first_name']);
                    $this->session->set_userdata('last_name', $user['last_name']);

                    $this->session->set_flashdata('success', 'Welcome back, ' . $user['first_name'] . '!');

                    // Redirect by role
                    if ($user['role'] === 'admin') {
                        redirect('students/get-all');
                    } else {
                        redirect('user/dashboard');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Invalid email or password.');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Validation failed. Please check your inputs.');
                redirect('auth/login');
            }
        }

        // Load login view
        $this->call->view('auth/login', [
            'success' => $this->session->flashdata('success'),
            'error'   => $this->session->flashdata('error')
        ]);
    }

    /** ---------------- REGISTER ---------------- */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Validation rules
            $this->form_validation->name('first_name')->required()->max_length(50);
            $this->form_validation->name('last_name')->required()->max_length(50);
            $this->form_validation->name('email')->required()->valid_email()->max_length(100);
            $this->form_validation->name('password')->required()->min_length(6)->max_length(20);
            $this->form_validation->name('confirm_password')->required();

            $old_input = $_POST; // save old input in case of errors

            // Confirm password check
            if (isset($_POST['password'], $_POST['confirm_password']) && $_POST['password'] !== $_POST['confirm_password']) {
                $this->session->set_flashdata('error', 'Passwords do not match.');
                $this->session->set_flashdata('old', $old_input);
                redirect('auth/register');
                return;
            }

            if ($this->form_validation->run()) {
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
                $role = 'user'; // default role

                // Check if email exists
                if ($this->StudentsModel->find_by_email($email)) {
                    $this->session->set_flashdata('error', 'Email already exists.');
                    $this->session->set_flashdata('old', $old_input);
                    redirect('auth/register');
                    return;
                }

                // Handle photo upload
                $photo = 'default.png'; // default image
                if (!empty($_FILES['photo']['name'])) {
                    $upload_dir = APP_DIR . 'public/uploads/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    $filename = time() . '_' . basename($_FILES['photo']['name']);
                    $target_file = $upload_dir . $filename;

                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
                        $photo = $filename;
                    }
                }

                // Create account
                $this->StudentsModel->create_account([
                    'first_name' => trim($_POST['first_name']),
                    'last_name'  => trim($_POST['last_name']),
                    'email'      => $email,
                    'password'   => $password, // hashed in model
                    'role'       => $role,
                    'photo'      => $photo
                ]);

                $this->session->set_flashdata('success', 'Account created successfully. Please login.');
                redirect('auth/login');

            } else {
                // Validation failed
                $this->session->set_flashdata('error', 'Validation failed. Please check your inputs.');
                $this->session->set_flashdata('old', $old_input);
                redirect('auth/register');
            }
        }

        // Load register view
        $this->call->view('auth/register', [
            'success' => $this->session->flashdata('success'),
            'error'   => $this->session->flashdata('error'),
            'old'     => $this->session->flashdata('old') ?? []
        ]);
    }
    /** ---------------- LOGOUT ---------------- */
    public function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('first_name');
        $this->session->unset_userdata('last_name');

        $this->session->set_flashdata('success', 'You have been logged out successfully.');
        redirect('auth/login');
    }
}
