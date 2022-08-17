<?php

    header("Access-Control-Allow-Origin: http://authentication-jwt/");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once 'jsondb.php';
    include_once 'user.php';
    
    session_start();

    $jdb = new Jsondb();

    $user = new User();

    $data = json_decode(file_get_contents("php://input"));

    $user->login = $data->login;
    $user_exists = $user->userExist();    

    if ($user_exists && password_verify($data->password, $user->password)){

        setcookie("login", $user->login, time()+84500, "/");

        $_SESSION['user_name'] = $user->name;   

        http_response_code(200); 
        echo json_encode(array("message" => "Успешно!", "name" => $user->name));

    }
    else{
        http_response_code(401);
        echo json_encode(array("message" => "Ошибка входа."));
    }   

?>

