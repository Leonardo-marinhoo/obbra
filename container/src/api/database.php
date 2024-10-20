<?php
ob_start();
define('DB_HOST', 'db'); //HOST = NOME DO SERVIÇO DOCKER
define('DB_USER', 'root');
define('DB_PASSWORD', 'muitaobra');
define('DB_NAME','obbra_v2');

class Database{
   
function Connect(){
    
    try{
        $PDO = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
        // $PDO = new PDO("mysql:host=db;dbname=obbra_v2","root","muitaobra");
        return $PDO;
    }catch(PDOException $e){
        echo $e;
        
    }


}

}

// ob_start();
// define('DB_HOST', 'localhost'); //HOST = NOME DO SERVIÇO DOCKER
// define('DB_USER', 'u795618026_leocodes');
// define('DB_PASSWORD', '|S6ePF8Nf');
// define('DB_NAME','u795618026_obbra_v2');

// class Database{
   
// function Connect(){
    
//     try{
//         $PDO = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
//         return $PDO;
//     }catch(PDOException $e){
//         echo $e;
        
//     }


// }

// }




?>



