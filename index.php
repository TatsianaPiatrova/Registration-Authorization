<?php

    include_once 'jsondb.php';
    include_once 'user.php';

    $jdb = new Jsondb();

    $user = new User();

    $user->login = 'tatsianapiatrova';
    $user->name = 'tatsianapiatrova';
    $user->email = 'tatsianapiatrova@mail.ru';
    $user->password = 1;
    print_r($user->userExist());
    print_r($user->id);
    print_r($jdb->create($user->create()));


?>