<?php

// относительно index.php
require_once '../src/models/User.php';

// Что содержит файл:
// <id> <name> <sername> <sex> <birthDate> <birthPlace> <createdDate> <updateDate>

class UserFile {
    private $filePath = '../db';
    private $users;

    private const ELEMENTS_COUNT_IN_FILE = 8;

    public function __construct() {
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, '');
            $this->users = [];
        } else {
            $this->users = $this->readUsers();
        }
    }

    public function isValidChange($text) {
        $elements = explode("\n", $text);
        
        foreach ($elements as $el) {
            if(count(explode(' ', $el)) !== self::ELEMENTS_COUNT_IN_FILE){
                return false;
            }
        }

        return true;
    }

    public function saveText($text) {
        file_put_contents($this->filePath, $text);
    }

    public function readAllFile() {
        return file_get_contents($this->filePath);
    }

    public function readUsers() {
        $handle = fopen($this->filePath, 'r');
        $users = [];

        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            $elements = explode(' ', $line);
            $count = count($elements);

            if(count($elements) !== self::ELEMENTS_COUNT_IN_FILE) {
                throw new Exception("Db file invalid. Some row has " . count($elements) . " elements");
            }

            $users[] = User::createUserFromFile(
                $elements[0],
                $elements[1],
                $elements[2],
                $elements[3],
                $elements[4],
                $elements[5],
                $elements[6],
                $elements[7],
            );
        }
        fclose($handle);

        return $users;
    }

    public function findUser($id) {
        foreach ($this->users as $user) {
            if($user->id === $id){
                return $user;
            }
        }
    
        return null;
    }

    public function addUser(User $user) {
        $this->users[] = $user;
        $this->writeFile();
    }

    public function changeUser(User $user, $name, $sername, $sex, $birthDate, $birthPlace) {
        $user->name = $name;
        $user->sername = $sername;
        $user->sex = $sex;
        $user->birthDate = $birthDate;
        $user->birthPlace = $birthPlace;
        $user->updatedDate = date('Y-m-d_H:i:s');

        $this->writeFile();
    }

    public function deleteUser($id) {
        $this->users = array_filter($this->users, function($user) use ($id) {
            return $user->id !== $id;
        });

        $this->writeFile();
    }

    private function writeFile() {
        $handle = fopen($this->filePath, 'w');

        foreach ($this->users as $user) {
            $line = $user->id . ' ' . 
                $user->name . ' ' . 
                $user->sername . ' ' . 
                $user->sex . ' ' . 
                $user->birthDate . ' ' . 
                $user->birthPlace . ' ' . 
                $user->createdDate . ' ' . 
                $user->updatedDate . "\n";

            fwrite($handle, $line);
        }

        fclose($handle);
    }
}