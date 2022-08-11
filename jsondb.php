<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    class Jsondb{

        public $filename = 'data.json';

        function __construct(){

        }

        function create($newData){
            $data = $this->read();
            if (!empty($data)){
                for ($i = 0; $i < count($data); $i++){
                    if (strcmp($newData['login'], $data[$i]->login) === 0)
                        return false;
                }
                for ($i = 0; $i < count($data); $i++){
                    if(strcmp($newData['email'], $data[$i]->email) === 0)                       
                        return false;
                }
            }
            $data[] = $newData;
            $json = json_encode($data);
            file_put_contents($this->filename, $json);  
            return true;          
        }

        function read(){
            $data = json_decode(file_get_contents($this->filename));
            return $data;
        } 

        function delete($id){
            $data = $this->read();
            if (!empty($data)){
                unset($data[$id]);
                $json = json_encode($data);
                file_put_contents($this->filename, $json);
                return true;
            }
            else return false;
        }

        function update($updateData){
            $data = $this->read();
            if (!empty($data)){
                for ($i = 0; $i < count($data); $i++){
                    if($updateData['id'] === $i){
                        $data[$i]->login = $updateData['login'];
                        $data[$i]->name = $updateData['name'];
                        $data[$i]->email = $updateData['email'];
                    }
                }
                $json = json_encode($data);
                file_put_contents($this->filename, $json);
                return true;
            }
            else return false;
        }
    }

?>