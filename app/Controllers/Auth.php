<?php

namespace App\Controllers;

use App\Models\Auth_Model;
use Config\Services;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $session;
    protected $userauth;
    protected $validation;

    protected $encrypter;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->userauth = new Auth_Model();
        $this->validation = \Config\Services::validation();
        $this->encrypter = Services::encrypter();
    }

    public function index(): string
    {

        // Set title untuk halaman login
        $data['title'] = 'SignIn User';

        return view("auth/Index", $data);
    }

    public function login()
    {
        // Cek apakah pengguna sudah login
        if ($this->session->get('logged_in')) {
            $role = $this->session->get('role');
            // Redirect pengguna yang sudah login ke halaman yang sesuai
            if ($role === 'admin') {
                return redirect()->to('/Admin')->with('info', 'Anda sudah login sebagai admin.');
            } else {
                return redirect()->to('/')->with('info', 'Anda sudah login.');
            }
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validasi input
        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error-pw', 'Username dan password harus diisi.');
        }

        $user = $this->userauth->getUserByUsername($username);

        if ($user) {
            // Cek apakah key 'is_active' ada di array $user
            if (!isset($user['flag'])) {
                return redirect()->back()->with('error-pw', 'Invalid input');
            }

            if ($user['flag'] == 0) {
                return redirect()->back()->with('error-pw', 'Your account is not activated yet. Please check your email');
            }

            if (password_verify($password, $user['password'])) {
                $session = session();
                $session->regenerate(); // Regenerasi ID session
                $session->set([
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'logged_in' => true
                ]);

                if ($user['role'] == 'admin') {
                    return redirect()->to('/Admin');
                } else {
                    return redirect()->to('/');
                }
            }
        }

        return redirect()->back()->with('error-pw', 'Username atau password salah.');
    }


    public function form_register()
    {
        // Set title untuk halaman login
        $data['title'] = 'SignUp User';
        return view('auth/register', $data);
    }

    public function proses_register_user()
    {
        $validation = \Config\Services::validation();

        // Lakukan validasi menggunakan rules yang telah didefinisikan
        if (!$validation->run($this->request->getPost(), 'registration')) {
            // Jika validasi gagal, kembali ke form dengan error
            $errors = $validation->getErrors();
            $errorMessages = implode($errors);
            return redirect()->back()->withInput()->with('error-pass', '<small>' . $errorMessages . '</small>');
        }


        $data = $this->request->getPost();

        // Sanitasi input
        foreach ($data as $key => $value) {
            $data[$key] = esc($value);
        }

        // Check if email is already used
        $existingUsername = $this->userauth->where('nama', $data['nama'])->first();
        if ($existingUsername) {
            // Email already exists, redirect back with an error message
            return redirect()->back()->withInput()->with('error-name', '<small>nama telah digunakan</small>');
        }

        // Validate email domain
        if (!preg_match('/@(ub\.ac\.id|student\.ub\.ac\.id)$/', $data['email'])) {
            return redirect()->back()->withInput()->with('error-mail', '<small>Pendaftaran hanya diperbolehkan dengan email universitas</small>');
        }

        $existingUser = $this->userauth->where('email', $data['email'])->first();
        if ($existingUser) {
            // Email already exists, redirect back with an error message
            return redirect()->back()->withInput()->with('error-mail', '<small>Email telah digunakan</small>');
        }

        if (!isset($data['confirm_password']) || $data['password'] !== $data['confirm_password']) {
            return redirect()->back()->withInput()->with('error-pass', '<small>Password dan konfirmasi password tidak cocok.</small>');
        }


        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['status'] = 'user'; // Assuming this sets the user role or status
            $data['flag'] = 0; // Assuming this is used to track some sort of activation or confirmation status
            $data['token'] = md5(bin2hex(random_bytes(16)));
            // $data['date_register']= date("Y-m-d H:i:s"); 
        }

        unset($data['confirm_password']);

        if ($this->userauth->save($data)) {
            // Assuming 'email' is a field in your form and hence in $data
            $this->_sendConfirmationEmail($data['email'], $data['token']);
            // Redirect to login with a success message
            return redirect()->to('SignIn')->with('message', 'Registration successful! Please check your email for confirmation.');
        } else {
            // Handle failure, e.g., show an error message
            return redirect()->back()->withInput()->with('error', 'Registration failed. Please try again.');
        }
    }

    private function _sendConfirmationEmail($userEmail, $token)
    {
        $email = \Config\Services::email();

        // Configure email settings
        $email->setFrom('moko1@dotsnusa.com', 'ULTKSP VOKASI UB');
        $email->setTo($userEmail);
        $email->setSubject('Account Activation');
        $activationLink = site_url("/activate/$token");

        $emailContent = view('emails/activation', ['activationLink' => $activationLink]);


        $email->setMessage($emailContent);

        if (!$email->send()) {
            // Optionally, log the error or handle it as required
            log_message('error', 'Failed to send confirmation email to: ' . $userEmail);
        }
    }


    public function activate($token)
    {
        // Attempt to find the record by token
        $user = $this->userauth->where('token', $token)->where('flag', 0)->first();
        // Attempt to find the record by token
        $user2 = $this->userauth->where('token', $token)->where('flag', 1)->first();


        if ($user) {
            // Jika ditemukan, aktifkan akun
            $this->userauth->update($user['id'], ['flag' => 1]);
            $message = "Akun Anda berhasil diaktifkan.";
        } elseif ($user2) {
            // Jika akun sudah pernah diaktifkan
            $message = "Akun Anda sudah pernah diaktifkan.";
        } else {
            // Jika gagal mengaktifkan
            $message = "Akun Anda gagal diaktifkan.";
        }

        $data = [
            'message' => $message,
            'title' => "Reset Password",

        ];

        // Load view aktivasi dengan pesan yang sesuai
        return view('auth/activation', $data);
    }


    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/SignIn');
    }

    public function forgot_password()
    {
        // Set title untuk halaman login
        $data['title'] = 'Forgot Password';
        return view('Auth/forgot_password', $data);
    }

    public function process_forgot_password()
    {
        $email = $this->request->getPost('email');

        // Validate input
        if (empty($email)) {
            return redirect()->back()->with('error', 'Email must be provided.');
        }

        // Check if email exists
        $user = $this->userauth->where('email', $email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Email not found.');
        }

        // Generate token and save it
        $token = md5(bin2hex(random_bytes(16)));
        $updateResult = $this->userauth->update($user['id'], ['token' => $token]);

        if (!$updateResult) {
            return redirect()->back()->with('error', 'Failed to update token.');
        }

        // Log token
        log_message('info', 'Generated token: ' . $token);

        // Send reset email
        $this->_sendResetEmail($email, $token);

        return redirect()->to('forgot-password')->with('success', 'Please check your email for password reset instructions.');
    }

    private function _sendResetEmail($userEmail, $token)
    {
        $email = \Config\Services::email();

        // Configure email settings
        $email->setFrom('moko1@dotsnusa.com', 'ULTKSP VOKASI UB');
        $email->setTo($userEmail);
        $email->setSubject('Password Reset Request');
        $resetLink = site_url("reset-password/$token");

        $emailContent = view('emails/reset', ['resetLink' => $resetLink]);

        $email->setMessage($emailContent);

        if (!$email->send()) {
            log_message('error', 'Failed to send reset email to: ' . $userEmail);
        }
    }

    public function reset_password($token)
    {
        // Check if the token is valid (e.g., exist in the database)
        $user = $this->userauth->where('token', $token)->first();

        if (!$user) {
            // Handle invalid token
            return redirect()->to('/forgot-password')->with('error', 'Invalid or expired token.');
        }

        // Kirim data ke view
        $data = [
            'token' => $token,
            'title' => "Reset Password",

        ];

        // Pass the token to the view
        return view('auth/reset_password', $data);
    }

    public function process_reset_password()
    {
        $rules = [
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required|min_length[8]|regex_match[/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/]',
                'errors' => [
                    'required' => 'Password is required.',
                    'min_length' => 'Password must be at least 8 characters long.',
                    'regex_match' => 'Password must contain at least one uppercase letter, one number, and one special character.',
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            // Validation failed, return back with errors
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirm_password');


        // Validate input
        if (empty($password) || empty($confirm_password)) {
            return redirect()->back()->with('error', ' password fields are required.');
        }

        if ($password !== $confirm_password) {
            return redirect()->back()->with('error', 'Passwords do not match.');
        }

        // Find user by token
        $user = $this->userauth->where('token', $token)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Invalid or expired token.');
        }

        // Update password and clear token
        $this->userauth->update($user['id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'token' => null // Clear the token after password reset
        ]);

        return redirect()->to('/SignIn')->with('message', 'Password has been reset successfully. You can now log in with your new password.');
    }
}
