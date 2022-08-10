<?php

    header("Access-Control-Allow-Origin: http://authentication-jwt/");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once 'jsondb.php';
    include_once 'user.php';
    
    $jdb = new Jsondb();
    
    $user = new User();

    $data = json_decode(file_get_contents("php://input"));

    $user->login = $data->login;
    $user->name = $data->name;
    $user->email = $data->email;
    $user->password = $data->password;
    
    if (
        !empty($user->login) &&
        !empty($user->email) &&
        !empty($user->name) &&
        !empty($user->password) &&
        $jdb->create($user->create())
    ) {
        http_response_code(200);
        echo json_encode(array("message" => "Пользователь был создан."));
    }
    else {
        http_response_code(400);
        echo json_encode(array("message" => "Невозможно создать пользователя."));
    }
?>