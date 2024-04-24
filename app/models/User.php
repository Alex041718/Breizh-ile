<?php

namespace model;

class User {
    public $id;
    public $name;
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $role;

    public function __construct($id, $name, $firstName, $lastName, $email, $password, $role) {
        $this->id = $id;
        $this->name = $name;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function getRole() {
        return $this->role;
    }
}
?>