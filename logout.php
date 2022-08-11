<?php
     if (isset($_POST)){
        if(isset($_COOKIE['login'])){
            setcookie("login", $user->login, time()-84500, "/");
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