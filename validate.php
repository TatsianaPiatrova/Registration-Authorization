<?php

    session_start();
    if (isset($_POST)){
        if(isset($_COOKIE['login'])){
            $user = new User();
            $user->login = $_COOKIE['login'];
            if($user->userExist()){
                http_response_code(200); 
                echo json_encode(array("message" => "Успешно!"));
            }
            else{
                http_response_code(401);
                echo json_encode(array("message" => "Ошибка входа."));
            }            
        }
        else{
            http_response_code(401);
            echo json_encode(array("message" => "Ошибка входа."));
        }  
    } 
?>