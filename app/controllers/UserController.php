<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserController extends Controller {
    private $upload_dir;
    private $upload_url;

    public function __construct() {
        parent::__construct();
        $this->call->library('session');
        $this->call->model('StudentsModel');

        // 📂 Uploads directory
        $this->upload_dir = realpath(__DIR__ . '/../../public/uploads') . '/';
        $this->upload_url = BASE_URL . 'public/uploads/';

        if (!is_dir($this->upload_dir)) {
            mkdir($this->upload_dir, 0777, true);
        }

        // 🔐 Require login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    /** 🏠 User Dashboard */
    public function dashboard() {
        $this->call->view('user/dashboard', [
            'success' => $this->session->flashdata('success'),
            'error'   => $this->session->flashdata('error')
        ]);
    }

    /** 👤 Show Profile */
    public function profile() {
        $user_id = $this->session->userdata('user_id');
        $user = $this->StudentsModel->find($user_id);

        $this->call->view('user/profile', [
            'user'       => $user,
            'upload_url' => $this->upload_url,
            'success'    => $this->session->flashdata('success'),
            'error'      => $this->session->flashdata('error')
        ]);
    }

    /** ✏️ Update Own Profile */
    public function update_profile() {
        $id = $this->session->userdata('user_id');
        $contents = $this->StudentsModel->find($id);

        $this->call->library('form_validation');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->form_validation->name('first_name')->required()->max_length(50);
            $this->form_validation->name('last_name')->required()->max_length(50);
            $this->form_validation->name('email')->required()->valid_email()->max_length(100);

            if ($this->form_validation->run()) {
                $photo = $contents['photo'];

                // 📤 Handle photo upload
                if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {
                    $this->call->library('upload', $_FILES['photo']);
                    $this->upload->set_dir($this->upload_dir)
                                ->allowed_extensions(['jpg','jpeg','png'])
                                ->allowed_mimes(['image/jpeg','image/png'])
                                ->max_size(2)
                                ->is_image();
                    if ($this->upload->do_upload()) {
                        $photo = $this->upload->get_filename();
                    }
                }

                $data = [
                    'first_name' => $_POST['first_name'],
                    'last_name'  => $_POST['last_name'],
                    'email'      => $_POST['email'],
                    'password'   => !empty($_POST['password']) ? $_POST['password'] : $contents['password'],
                    'photo'      => $photo
                ];

                $this->StudentsModel->update($id, $data);

                // ✅ Update session para consistent ang pangalan sa dashboard/profile
                $this->session->set_userdata('first_name', $_POST['first_name']);
                $this->session->set_userdata('last_name', $_POST['last_name']);

                $this->session->set_flashdata('success', '✅ Your profile has been updated!');
                redirect('user/profile');
            } else {
                $this->session->set_flashdata('error', '❌ Validation failed. Please check your inputs.');
                redirect('user/profile');
            }
        }

        // Default load profile page
        $this->call->view('user/profile', [
            'user'       => $contents,
            'upload_url' => $this->upload_url,
            'success'    => $this->session->flashdata('success'),
            'error'      => $this->session->flashdata('error')
        ]);
    }
}
