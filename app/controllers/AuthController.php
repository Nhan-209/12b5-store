<?php
namespace App\Controllers;

use App\Models\User;
use App\Core\Csrf;

class AuthController {
    public function login(): void {
        if (!empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validate()) {
                $error = 'Mã bảo mật CSRF không hợp lệ hoặc phiên đã hết hạn. Vui lòng thử lại.';
                require __DIR__ . '/../views/auth/login.php';
                return;
            }

            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = 'Vui lòng nhập đầy đủ email và mật khẩu.';
                require __DIR__ . '/../views/auth/login.php';
                return;
            }

            $user = User::verifyCredentials($email, $password);
            if ($user) {
                // Mitigate session fixation by regenerating session ID upon login
                session_regenerate_id(true);
                $_SESSION['user'] = $user;
                $_SESSION['flash_success'] = 'Đăng nhập thành công! Chào mừng ' . htmlspecialchars($user['name']);

                if ($user['role'] === 'admin') {
                    header('Location: ' . BASE_URL . '/admin');
                } else {
                    header('Location: ' . BASE_URL . '/');
                }
                exit;
            } else {
                $error = 'Email hoặc mật khẩu không chính xác.';
                require __DIR__ . '/../views/auth/login.php';
                return;
            }
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function register(): void {
        if (!empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validate()) {
                $error = 'Mã bảo mật CSRF không hợp lệ hoặc phiên đã hết hạn. Vui lòng thử lại.';
                require __DIR__ . '/../views/auth/register.php';
                return;
            }

            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $phone = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? '');

            if (empty($name) || empty($email) || empty($password)) {
                $error = 'Vui lòng điền đầy đủ các thông tin bắt buộc.';
                require __DIR__ . '/../views/auth/register.php';
                return;
            }

            if ($password !== $confirmPassword) {
                $error = 'Mật khẩu xác nhận không khớp.';
                require __DIR__ . '/../views/auth/register.php';
                return;
            }

            if (strlen($password) < 6) {
                $error = 'Mật khẩu phải có ít nhất 6 ký tự.';
                require __DIR__ . '/../views/auth/register.php';
                return;
            }

            if (User::findByEmail($email)) {
                $error = 'Email này đã được đăng ký tài khoản.';
                require __DIR__ . '/../views/auth/register.php';
                return;
            }

            $userId = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'phone' => $phone,
                'address' => $address,
                'role' => 'customer'
            ]);

            $_SESSION['flash_success'] = 'Đăng ký thành công! Quý khách vui lòng đăng nhập.';
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        require __DIR__ . '/../views/auth/register.php';
    }

    public function logout(): void {
        unset($_SESSION['user']);
        session_regenerate_id(true);
        $_SESSION['flash_success'] = 'Đã đăng xuất tài khoản.';
        header('Location: /');
        exit;
    }

    public function profile(): void {
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $userId = (int)$_SESSION['user']['id'];
        $user = User::findById($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::validate()) {
                $_SESSION['flash_error'] = 'Mã bảo mật CSRF không hợp lệ hoặc phiên đã hết hạn.';
                header('Location: ' . BASE_URL . '/profile');
                exit;
            }

            $name = trim($_POST['name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? '');

            if (!empty($name)) {
                User::updateProfile($userId, [
                    'name' => $name,
                    'phone' => $phone,
                    'address' => $address
                ]);
                $_SESSION['user']['name'] = $name;
                $_SESSION['flash_success'] = 'Cập nhật thông tin cá nhân thành công.';
                header('Location: ' . BASE_URL . '/profile');
                exit;
            }
        }

        require __DIR__ . '/../views/auth/profile.php';
    }
}
