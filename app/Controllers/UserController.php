<?php

namespace App\Controllers;


class UserController {

    public function loginPage()
    {
        $loginError = $_SESSION['login_error'];
        unset($_SESSION['login_error']);

        require __DIR__ . '/../assets/views/login.php';
    }

    public function login()
    {
        if ($this->checkAuth($_POST['login'], $_POST['pass'])) {
            $_SESSION['admin'] = true;
            header('Location: /');
        } else {
            $_SESSION['login_error'] = true;
            header('Location: /login');
        }
    }

    public function logout()
    {
        $_SESSION['admin'] = false;
        header('Location: /');
    }

    /**
     * @param string $login
     * @param string $pass
     * @return bool
     */
    protected function checkAuth($login, $pass)
    {
        $admin = [
            'login' => 'admin',
            'pass'  => '202cb962ac59075b964b07152d234b70'
        ];

        if ( ($login == $admin['login']) && (md5($pass) == $admin['pass']) ) {
            return true;
        }

        return false;
    }

}