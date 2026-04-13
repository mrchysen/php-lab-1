<?php

// относительно index.php
require_once '../src/models/GuidGenerator.php';

class User {
    public $id;
    public $name;
    public $sername;
    public $sex;
    public $birthDate;
    public $birthPlace;
    public $createdDate;
    public $updatedDate;

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