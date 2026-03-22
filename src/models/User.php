<?php

// относительно index.php
require_once '../src/models/GuidGenerator.php';

class User {
    public $id; // 32
    public $name; // 32
    public $sername; // 32
    public $sex; // 1
    public $birthDate; // 10
    public $birthPlace; // 128
    public $createdDate; // 10
    public $updatedDate; // 10

    // For adding
    public function __construct($name, $sername, $sex, $birthDate, $birthPlace) {
        $this->id = generateGUID();
    
        $this->name = $name;
        $this->sername = $sername;
        $this->sex = $sex;
        $this->birthDate = $birthDate;
        $this->birthPlace = $birthPlace;

        $this->createdDate = date('Y-m-d_H:i:s');
        $this->updatedDate = date('Y-m-d_H:i:s');
    }

    // For reading from file
    public static function createUserFromFile($id, $name, $sername, $sex, $birthDate, $birthPlace, $createdDate, $updatedDate){
        $user = new User($name, $sername, $sex, $birthDate, $birthPlace);
        $user->id = $id;
        $user->createdDate = $createdDate;
        $user->updatedDate = $updatedDate;

        return $user;
    }
}