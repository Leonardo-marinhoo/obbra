<?php
ob_start();

class Database{
   
function Connect(){
    
    try{
        $PDO = new PDO("mysql:host=localhost;dbname=obbra","root","");
        // returns PHP DATA OBJECT
        // echo "conectado";
        return $PDO;
    }catch(PDOException $e){
        echo $e;
        
    }


}

}
