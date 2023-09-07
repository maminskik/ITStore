<?php

require_once './libs/Database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function countUsers()
    {
        $this->db->query('SELECT COUNT(*) AS total_users FROM users');
        $row = $this->db->single();
        return $row;
    }

    public function editUser($name, $surname, $email, $is_active, $roleid, $userId)
    {

        $this->db->query('UPDATE users SET Name = :name, Surname = :surname, Email = :email, is_active = :is_active, RoleId = :roleid WHERE UserId = :userid');

        $this->db->bind(':userid', $userId);
        $this->db->bind(':name', $name);
        $this->db->bind(':surname', $surname);
        $this->db->bind(':email', $email);
        $this->db->bind(':is_active', $is_active);
        $this->db->bind(':roleid', $roleid);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteUser($userId)
    {
        $this->db->query("DELETE FROM users WHERE UserId = :userId");
        $this->db->bind(':userId', $userId);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllUsers($currentUserId)
    {
        $this->db->query("SELECT * FROM users WHERE UserId != :currentUserId");
        $this->db->bind(':currentUserId', $currentUserId);

        $users = $this->db->resultSet();
        return $users;
    }

    public function getAllRoles()
    {
        $this->db->query("SELECT * FROM role");

        $roles = $this->db->resultSet();
        return $roles;
    }

    public function findUseryById($id)
    {
        $this->db->query('SELECT * FROM users WHERE UserId = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    public function updateUserPassword($id, $password)
    {

        $this->db->query('UPDATE users SET Password = :password WHERE UserId = :id');
        $this->db->bind(':password', $password);
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUserEmail($id, $email)
    {
        $this->db->query('UPDATE users SET Email = :email WHERE UserId = :id');
        $this->db->bind(':email', $email);
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUserName($id, $name, $surname)
    {
        $this->db->query('UPDATE users SET Name = :name, Surname = :surname WHERE UserId = :id');
        $this->db->bind(':name', $name);
        $this->db->bind(':surname', $surname);
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();


        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function findActiveUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0 && $row->is_active == 0) {
            return true;
        } else {
            return false;
        }
    }


    public function registerUser($data)
    {
        $this->db->query('INSERT INTO users (name, surname, email, password, is_active, roleid)
        VALUES (:name, :surname, :email, :password, :is_active, :roleid)');

        $this->db->bind(':name', $data['userName']);
        $this->db->bind(':surname', $data['userSurname']);
        $this->db->bind(':email', $data['userEmail']);
        $this->db->bind(':password', $data['userPassword']);
        $this->db->bind(':is_active', 1);
        $this->db->bind(':roleid', 2);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $password)
    {
        $row = $this->findUserByEmail($email);

        if ($row == false) return false;

        $hashedPassword = $row->Password;
        if (password_verify($password, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['userEmail'] = $user->Email;
        $_SESSION['userId'] = $user->UserId;
        redirect("./index.php");
    }

    public function createAdminSession($admin)
    {
        $_SESSION['adminEmail'] = $admin->Email;
        $_SESSION['adminId'] = $admin->UserId;
        redirect("./admin_panel.php");
    }
}