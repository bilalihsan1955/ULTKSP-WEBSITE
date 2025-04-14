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
        $data['title'] = 'Sign In User';

        return view("auth/Index", $data);
    }

    public function login()
    {
        // Cek apakah pengguna sudah login
        if ($this->session->get('logged_in')) {
            $role = $this->session->get('role');
            // Redirect pengguna yang sudah login ke halaman yang sesuai
            if ($role === 'admin') {
                return redirect()->to('/Admin')->with('error', 'Anda sudah login sebagai admin.');
            } else {
                return redirect()->to('/Dashboard')->with('error', 'Anda sudah login.');
            }
        }
    
        $identifier = $this->request->getPost('username'); // Dapat berupa username atau email
        $password = $this->request->getPost('password');
    
        // Validasi input
        if (empty($identifier) || empty($password)) {
            return redirect()->back()->with('error', 'Username/email dan password harus diisi.');
        }
    
        // Periksa apakah input adalah email atau username
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            // Jika berupa email
            $user = $this->userauth->where('email', $identifier)->first();
        } else {
            // Jika berupa username
            $user = $this->userauth->where('username', $identifier)->first();
        }
    
        if ($user) {
            // Cek apakah key 'flag' ada di array $user
            if (!isset($user['flag'])) {
                return redirect()->back()->with('error', 'Invalid input');
            }
    
            if ($user['flag'] == 0) {
                return redirect()->back()->with('error', 'Akun Anda belum diaktifkan. Silakan periksa email Anda.');
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
                    return redirect()->to('/Dashboard');
                }
            }
        }
    
        return redirect()->back()->with('error', 'Username/email atau password salah.');
    }

    public function form_register()
    {
        // Set title untuk halaman login
        $data['title'] = 'Sign Up User';
        return view('auth/register', $data);
    }

    public function proses_register_user()
    {
        $validation = \Config\Services::validation();
    
        // Lakukan validasi menggunakan rules yang telah didefinisikan
        if (!$validation->run($this->request->getPost(), 'registration')) {
            // Jika validasi gagal, kembali ke form dengan error
            $errors = $validation->getErrors();
            return redirect()->back()->withInput()->with('error', $errors); // Mengirim error sebagai array
        }
    
        $data = $this->request->getPost();
    
        // Sanitasi input
        foreach ($data as $key => $value) {
            $data[$key] = esc($value);
        }
    
        // Check if email is already used
        $existingUsername = $this->userauth->where('nama', $data['nama'])->first();
        if ($existingUsername) {
            return redirect()->back()->withInput()->with('error', ['Nama telah digunakan']);
        }
    
        // Validate email domain
        if (!preg_match('/@(ub\.ac\.id|student\.ub\.ac\.id)$/', $data['email'])) {
            return redirect()->back()->withInput()->with('error', ['Pendaftaran hanya diperbolehkan dengan email universitas']);
        }
    
        $existingUser = $this->userauth->where('email', $data['email'])->first();
        if ($existingUser) {
            return redirect()->back()->withInput()->with('error', ['Email telah digunakan']);
        }
    
        if (!isset($data['confirm_password']) || $data['password'] !== $data['confirm_password']) {
            return redirect()->back()->withInput()->with('error', ['Password dan konfirmasi password tidak cocok.']);
        }
    
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['status'] = 'user';
            $data['flag'] = 0;
            $data['token'] = md5(bin2hex(random_bytes(16)));
        }
    
        unset($data['confirm_password']);
    
        if ($this->userauth->save($data)) {
            $this->_sendConfirmationEmail($data['email'], $data['token']);
            return redirect()->to('SignIn')->with('message', 'Registrasi berhasil! Silakan periksa email Anda untuk konfirmasi.');
        } else {
            return redirect()->back()->withInput()->with('error', ['Registrasi gagal. Silakan coba lagi.']);
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
            return redirect()->back()->with('error', 'Gagal mengirim email konfirmasi ke:  ' . $userEmail);
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
            'title' => "Aktivasi Akun Anda",

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
            return redirect()->back()->with('error', 'Email harus diisi!');
        }

        // Check if email exists
        $user = $this->userauth->where('email', $email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }

        // Generate token and save it
        $token = md5(bin2hex(random_bytes(16)));
        $updateResult = $this->userauth->update($user['id'], ['token' => $token]);

        if (!$updateResult) {
            return redirect()->back()->with('error', 'Gagal memperbarui token.');
        }

        // Log token
        return redirect()->back()->with('error', 'Generated token: ');

        // Send reset email
        $this->_sendResetEmail($email, $token);

        return redirect()->to('forgot-password')->with('success', 'Silakan periksa email Anda untuk instruksi pengaturan ulang kata sandi.');
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
            return redirect()->back()->with('error', 'Gagal mengirim email ke: ' . $userEmail);
        }
    }

    public function reset_password($token)
    {
        // Check if the token is valid (e.g., exist in the database)
        $user = $this->userauth->where('token', $token)->first();

        if (!$user) {
            // Handle invalid token
            return redirect()->to('/forgot-password')->with('error', 'Token tidak valid atau telah kedaluwarsa.');
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
                    'required' => 'Kolom password wajib diisi.',
                    'min_length' => 'Password harus terdiri dari minimal 8 karakter.',
                    'regex_match' => 'Password harus memiliki minimal satu huruf besar, satu angka, dan satu karakter khusus.',
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            // Validation failed, return back with errors
            return redirect()->back()->withInput()->with('error', $this->validation->getErrors());
        }

        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirm_password');


        // Validate input
        if (empty($password) || empty($confirm_password)) {
            return redirect()->back()->with('error', ' Kolom password wajib diisi.');
        }

        if ($password !== $confirm_password) {
            return redirect()->back()->with('error', 'Confirm Passwords tidak cocok.');
        }

        // Find user by token
        $user = $this->userauth->where('token', $token)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Token tidak valid atau telah kedaluwarsa.');
        }

        // Update password and clear token
        $this->userauth->update($user['id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'token' => null // Clear the token after password reset
        ]);

        return redirect()->to('/SignIn')->with('message', 'Password Anda berhasil direset. Sekarang Anda bisa masuk dengan password baru Anda.');
    }
}
