<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function register()
    {
        return view('auth/register');
    }

    public function registerPost()
    {
        try {
            $userModel = new UserModel();

            $name = trim((string) $this->request->getPost('name'));
            $email = trim((string) $this->request->getPost('email'));
            $password = (string) $this->request->getPost('password');

            if ($name === '' || $email === '' || $password === '') {
                return redirect()->back()->withInput()->with('error', 'All fields are required.');
            }

            $existingUser = $userModel->where('email', $email)->first();

            if ($existingUser) {
                return redirect()->back()->withInput()->with('error', 'Email already exists.');
            }

            $saved = $userModel->insert([
                'name'       => $name,
                'email'      => $email,
                'password'   => password_hash($password, PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if (!$saved) {
                return redirect()->back()->withInput()->with('error', 'Registration failed.');
            }

            return redirect()->to(base_url('index.php/login'))->with('success', 'Registration successful. Please login.');
        } catch (\Throwable $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function login()
    {
        return view('auth/login');
    }

    public function loginPost()
    {
        try {
            $userModel = new UserModel();

            $email = trim((string) $this->request->getPost('email'));
            $password = (string) $this->request->getPost('password');

            if ($email === '' || $password === '') {
                return redirect()->back()->withInput()->with('error', 'Email and password are required.');
            }

            $user = $userModel->where('email', $email)->first();

            if (!$user || !password_verify($password, $user['password'])) {
                return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
            }

            session()->set([
                'user_id'   => $user['id'],
                'user_name' => $user['name'],
                'logged_in' => true,
            ]);

            return redirect()->to(base_url('index.php/'));
        } catch (\Throwable $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('index.php/login'))->with('success', 'Logged out successfully.');
    }
}