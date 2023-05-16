<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php'; //nie było ładowane na filmiku
class SecurityController extends AppController
{
    public function login()
    {
        $userRepository = new UserRepository();
        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $userRepository->getUser($email);

        if (!$user) {
            return $this->render('login', ['messages' => ['User does not exist!']]);
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User with such email does not exist!']]);
        }

        // Porównanie zahashowanych haseł
        if (!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        $_SESSION['user_id'] = $user->getUserId();

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/main");
        // return $this->render('main'); //second option of doing the same thing as above
    }

    public function register()
    {
        $this->userRepository = new UserRepository();

        if (!$this->isPost()) {
            return $this->render('register');
        }

        $login = $_POST['login'];
        $email = $_POST['email'];
        $confirmedEmail = $_POST['confirmedEmail'];
        $password = $_POST['password'];
        $confirmedPassword = $_POST['confirmedPassword'];

        $existingUserByEmail = $this->userRepository->getUser($email);
        if ($existingUserByEmail) {
            return $this->render('register', ['messages' => ['User with this email already exists']]);
        }
        $existingUserByLogin = $this->userRepository->getUserByLogin($login);
        if ($existingUserByLogin) {
            return $this->render('register', ['messages' => ['User with this login already exists']]);
        }

        if ($email !== $confirmedEmail) {
            return $this->render('register', ['messages' => ['Please provide matching email addresses']]);
        }

        if ($password !== $confirmedPassword) {
            return $this->render('register', ['messages' => ['Please provide matching passwords']]);
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $user = new User($login, $email, $hashedPassword);
        $this->userRepository->addUser($user);

        return $this->render('login', ['messages' => ['You have been successfully registered!']]);
    }
    public function logout() {
        session_unset();
        session_destroy();
        session_start();
        $this->render('login', ['messages' => ['You are now successfully logged out!']]);
    }
}