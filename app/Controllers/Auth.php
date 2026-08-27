<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('login');
    }
    public function register()
    {
        return view('register');
    }
    public function attemptLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $userModel = new UserModel();
        $user = $userModel
            ->where('email', $email)
            ->first();
        if (!$user) {
            return redirect()
                ->back()
                ->with('error', 'Invalid email or password.');
        }
        if (!password_verify($password, $user['hash_password'])) {
            return redirect()
                ->back()
                ->with('error', 'Invalid email or password.');
        }
        session()->set([
            'user_id' => $user['user_id'],
            'username'    => $user['username'],
            'email'   => $user['email'],
            'hash_password' => $user['hash_password'],
            'role'    => $user['role'],
            'logged_at' => date('Y-m-d H:i:s'),
            'isLoggedIn' => true
        ]);
        return $this->redirectBasedOnRole($user['role']);
    }
    public function attemptRegister()
    {
        $name = trim($this->request->getPost('name'));
        $email = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');

        if (empty($name) || empty($email) || empty($password)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'All fields are required.');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Please enter a valid email address.');
        }
        if (strlen($password) < 8) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Password must be at least 8 characters.');
        }
        $userModel = new UserModel();
        $existingUser = $userModel
            ->where('email', $email)
            ->first();
        if ($existingUser) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An account with this email already exists.');
        }
        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );
        $userModel->insert([
            'username'      => $name,
            'email'         => $email,
            'hash_password' => $hashedPassword,
            'role'          => 'staff'
        ]);
        return redirect()
            ->to('/login')
            ->with('success', 'Registration successful! You can now log in.');
    }
    private function redirectBasedOnRole($role)
    {
        switch ($role) {

            case 'admin':
                return redirect()->to('/admin_dashboard');
            case 'staff':
                return redirect()->to('/staff_dashboard');
            default:
                session()->destroy();
                return redirect()
                    ->to('/login')
                    ->with('error', 'Invalid user role.');
        }
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}
