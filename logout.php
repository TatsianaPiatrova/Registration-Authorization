<?php

    session_start();
    print_r($_COOKIE);
     if (isset($_POST)){
        if(isset($_COOKIE['login'])){
            setcookie("login", "", time()-84500, "/");
            unset($_SESSION['user_name']);
            session_abort();
            http_response_code(200); 
            echo json_encode(array("message" => "Успешно!"));
        }
        else{
            http_response_code(401);
            echo json_encode(array("message" => "Ошибка выхода."));
        } 
    }
    else{
        http_response_code(401);
        echo json_encode(array("message" => "Ошибка выхода."));
    }  
?>