<?php
require_once ("./src/api/database.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $db = new Database();
    $pdo = $db->Connect();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=:username AND password=:password");

    $stmt->bindParam(':username', $username);
    $stmt->bindParam("password", $password);
    try{
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        session_start();
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['user_name'] = $result['name']." ". $result['surname'];
        $_SESSION['user_role'] = $result['role'];

        echo json_encode($result);
        header('Location:index.php');
    }catch(PDOException $e){
        echo $e;
    }
}

?>