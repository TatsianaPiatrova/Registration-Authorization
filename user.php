<?php

    class User {
    
        public $id;
        public $login;
        public $name;
        public $email;
        public $password;
    
        public function __construct() {
        }

        function create() {
        
            $this->login=htmlspecialchars(strip_tags($this->login));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->password=htmlspecialchars(strip_tags($this->password));
        
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $this->password = $password_hash;

            $data = array("login"=>$this->login, "name"=>$this->name, "email"=>$this->email, "password"=>$this->password);

            return $data;
        }

        function userExist(){
            $jdb = new Jsondb();
            $data = $jdb->read();
            for ($i=0; $i<count($data); $i++){
                if (strcmp($this->login, $data[$i]->login) === 0){
                    $this->id = $i;
                    $this->name = $data[$i]->name;
                    $this->email = $data[$i]->email;
                    $this->password = $data[$i]->password;
                    return true;
                 }
            }
            return false;
        }
    }
?>