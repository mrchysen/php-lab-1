<?php

require_once '../src/controllers/UserController.php';

// GET - /users?filter=anton html с фильтрацией
// GET - /users/upsert?id=<USER_ID> html с формой изменения
// POST - /users/upsert - добавление / изменение
// POST - /users/delete?id=<USER_ID> - удаление
// POST - /users/change - изменение файла

session_start();
$controller = new UserController();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET': 

        switch (strtok($_SERVER['REQUEST_URI'], '?')) { 
            case "/users":
                $controller->getUsers($_GET["filter"] ?? "");
                break;
            case "/users/upsert":
                $controller->getUsersUpsert($_GET["id"] ?? "");
                break;
            default:
                echo "Not found";
                break;
        }

        break;
    case 'POST':

        switch (strtok($_SERVER['REQUEST_URI'], '?')) { 
            case "/users/delete":
                $controller->postUsersDelete($_GET["id"] ?? "");
                break;
            case "/users/upsert":
                $controller->postUsersUpsert($_POST);
                break;
            case "/users/change":
                $controller->postUsersChange($_POST["file"] ?? "");
                break;
            default:
                echo "Not found";
                break;
        }

        break;
    default:
        echo "Not Found";
}