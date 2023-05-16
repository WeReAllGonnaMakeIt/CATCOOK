<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users WHERE usr_email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            return null;
        }

        $user = new User(
            $userData['usr_login'],
            $userData['usr_email'],
            $userData['usr_password']
        );

        $user->setUserId($userData['usr_id']);

        return $user;
    }

    public function getUserByLogin(string $login): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users WHERE usr_login = :login
        ');
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            return null;
        }

        $user = new User(
            $userData['usr_login'],
            $userData['usr_email'],
            $userData['usr_password']
        );

        $user->setUserId($userData['usr_id']);

        return $user;
    }

    public function addUser(User $user)
    {
        $connection = $this->database->connect();
        $connection->beginTransaction();

        try {
            $stmt = $connection->prepare('
            INSERT INTO users (usr_login, usr_email, usr_password)
            VALUES (:login, :email, :password)
        ');

            $stmt->bindValue(':login', $user->getLogin(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
            $stmt->execute();

            $connection->commit();
        } catch (PDOException $e) {
            $connection->rollBack();
            throw $e;
        }
    }
}