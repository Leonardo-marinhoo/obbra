<?php
require_once 'path.php';
require_once $base_path . 'private/conf.php';

session_start();
$user = $_POST["user"];
$pwd = $_POST["password"];

// session_start();


 function auth($user,$password){    
     //echo "nafunção";
    $db = new Database();
    $pdo = $db->Connect();

    $stmt = $pdo->prepare("SELECT * FROM users WHERE(user=:user)");
    //$stmt = $pdo->prepare("INSERT INTO users(username,password) VALUES(:username,:password)");


    $stmt->bindParam(':user',$user,PDO::PARAM_STR);
    
    try{
       $stmt->execute();
       $result = $stmt ->fetch(PDO::FETCH_ASSOC);
       //COMPARA SENHA
       $password = md5($password);  
        if($result){
            if(!strcmp($password, $result["password"])){                              
                echo json_encode(array('status' => "Bem-Vindo $user"));
                // $_SESSION['usuario'] =$result['username'];
                $_SESSION['user_name']=$result["name"];
                $_SESSION['user_id']=$result['id'];
                $_SESSION['user_function']=$result['function'];
                $_SESSION['user_role']=$result['role'];
                // $_SESSION['função']=$result["função"];
                // $_SESSION['foto']=$result['foto'];
                header("Location:../../dashboard.php");
            }else{
                              
                echo json_encode(array('code' => 'SENHA INCORRETA'));                              
                session_abort();
            }
        }else{
            session_abort();        
            echo json_encode(array('code' => 'USUARIO NÃO ENCONTRADO'));
        }
           
        
    }catch(PDOException $e){
                    
            echo json_encode( array('LOGIN' => $e));
       
    }

 }  
 if(isset ($_POST["login"])){ 
    auth($user,$pwd);   
}

if($user||$pwd){
    auth($user,$pwd);   

}


