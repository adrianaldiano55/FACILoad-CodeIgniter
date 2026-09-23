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
        $id = trim((string) $this->request->getPost('id'));
        $password = $this->request->getPost('password');
        $email = trim((string) $this->request->getPost('email'));
        $userModel = new UserModel();
        $users = $userModel
            ->where('login_id', $id)
            ->where('email', $email)
            ->first();
        if (!$users || !password_verify($password, $users['hash_password'])) {
            return redirect()
                ->back()
                ->with('error', 'No User Available.');
        }
        session()->set([
            'id' => $users['id'],
            'username'    => $users['username'],
            'email'   => $users['email'],
            'hash_password' => $users['hash_password'],
            'role'    => $users['role'],
            'login_at' => date('Y-m-d H:i:s'),
            'isLoggedIn' => true
        ]);
        return $this->redirectBasedOnRole($users['role']);
    }
    public function attemptRegister()
    {
        $name = trim($this->request->getPost('name'));
        $email = trim($this->request->getPost('email'));
        $id = trim($this->request->getPost('id'));
        $password = $this->request->getPost('password');
        $academic_rank = trim($this->request->getPost('academic_rank'));
        $college = trim($this->request->getPost('college'));
        $department = trim($this->request->getPost('department'));

        if (empty($name) || empty($id) || empty($email) || empty($password)|| empty($academic_rank) || empty($college) || empty($department)) {
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
            'role'          => 'faculty',
            'login_id'      => $id,
            'logout_at'     => date('Y-m-d H:i:s'),
            'academic_rank' => $academic_rank,
            'college'       => $college,
            'department'    => $department
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
            case 'faculty':
                return redirect()->to('/faculty_dashboard');
            default:
                session()->destroy();
                return redirect()
                    ->to('/login')
                    ->with('error', 'Invalid user role.');
        }
    }

    public function logout()
    {
        $userId = session()->get('id');
        if ($userId) {
            (new UserModel())->update($userId, [
                'logout_at' => date('Y-m-d H:i:s'),
            ]);
        }
        session()->destroy();

        return redirect()->to('/login');
    }
}
