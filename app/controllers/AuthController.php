<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller {
    public function login(): void {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = User::findByEmail($email);
            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header('Location: /admin');
                } else {
                    header('Location: /cabinet');
                }
                exit;
            } else {
                $error = 'Неверный email или пароль.';
            }
        }
        $this->render('auth/login', ['error' => $error]);
    }

    public function register(): void {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $phone = trim($_POST['phone'] ?? '');

            if (empty($name) || empty($email) || empty($password) || empty($phone)) {
                $error = 'Заполните все поля.';
            } elseif (User::findByEmail($email)) {
                $error = 'Пользователь с таким email уже существует.';
            } else {
                if (User::create($name, $email, $password, $phone)) {
                    header('Location: /login');
                    exit;
                } else {
                    $error = 'Ошибка регистрации. Попробуйте позже.';
                }
            }
        }
        $this->render('auth/register', ['error' => $error]);
    }

    public function logout(): void {
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_role']);
        session_destroy();
        header('Location: /');
        exit;
    }
}