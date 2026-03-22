<?php

// относительно index.php
require_once '../src/views/View.php';
require_once '../src/models/User.php';
require_once '../src/models/UserFile.php';

class UserController {
    private $view;
    private $userFile;

    public function __construct() {
        $this->view = new View();
        $this->userFile = new UserFile();
    }

    // GET - /users?filter= html со списком пользаков
    public function getUsers(string $filter) {
        $users = $this->userFile->readUsers();
        
        if($filter === "__admin"){
            $_SESSION['admin'] = true;
        }

        if($filter !== null && $filter !== ""){
            $users = array_filter($users, function($user) use ($filter) {
                return strpos($user->sername, $filter) !== false;
            });
        }

        if(isset($_SESSION['admin'])) {
            echo $this->view->renderWithLayout("admin", ['file' => $this->userFile->readAllFile()]);
        } else {
            echo $this->view->renderWithLayout("users", ['users' => $users]);
        }
    }

    // GET - /users/upsert?id=<USER_ID> html с формой изменения
    public function getUsersUpsert(string $userId) {
        $user = null;
        if($userId !== ""){
            $user = $this->userFile->findUser($userId);
        }

        echo $this->view->renderWithLayout("users-upsert", ['user' => $user]);
    }

    // POST - /users/upsert - добавление / изменение
    public function postUsersUpsert($formValues) {
        if(isset($formValues['id'])){ // Update
            $user = $this->userFile->findUser($formValues['id']);

            if($user === null) {
                 $this->userFile->addUser(new User(
                    $formValues['name'] ?? "empty",
                    $formValues['sername'] ?? "empty",
                    $formValues['sex'] ?? "empty",
                    $formValues['birthDate'] ?? "empty",
                    $formValues['birthPlace'] ?? "empty"
                 ));
            } else {
                $this->userFile->changeUser(
                    $user,
                    $formValues['name'] ?? $user->name,
                    $formValues['sername'] ?? $user->sername,
                    $formValues['sex'] ?? $user->sex,
                    $formValues['birthDate'] ?? $user->birthDate,
                    $formValues['birthPlace'] ?? $user->birthPlace);
            }

        } else { // Insert
            $this->userFile->addUser(new User(
                $formValues['name'] ?? "empty",
                $formValues['sername'] ?? "empty",
                $formValues['sex'] ?? "empty",
                $formValues['birthDate'] ?? "empty",
                $formValues['birthPlace'] ?? "empty"
            ));
        }
        
        header('Location: /users');
        exit();
    }

    // POST - /users/delete?id=<USER_ID> - удаление
    public function postUsersDelete(string $userId) {
        $this->userFile->deleteUser($userId);

        header('Location: /users');
        exit();
    }

    // admin only
    // POST - /users/change - изменение файла
    public function postUsersChange(string $text) {
        echo "попытка изменения файла <br> " . $text;
    
        if(!isset($_SESSION['admin'])) {
            return;
        }

        if($this->userFile->isValidChange($text)){
            $this->userFile->saveText($text);
        }

        //header('Location: /users');
        //exit();
    }
}