<?php
require_once ('database.php');

$request = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

$db = new Database();

if ($request === "application/json") {
    $request_data = trim(file_get_contents("php://input"));
    $decoded_data = json_decode($request_data, true);
    $request_type = $decoded_data['request_type'];

    switch ($request_type) {
        case ('create_user'):
            create_user($decoded_data['stmt_data']);
            break;
        case ('update_user'):
            update_user($decoded_data['stmt_data']);
            break;
        case ('delete_user'):
            delete_user($decoded_data['stmt_data']);
            break;
        case ('read_user'):
            read_user($decoded_data['stmt_data']);
            break;
    }
}

function create_user($stmt_data) {
    global $db;
    $pdo = $db->Connect();
    $stmt = $pdo->prepare("INSERT INTO users (`id`, `name`, `surname`, `username`, `role`, `password`) VALUES (NULL, :name, :surname, :username, :role, :password)");

    $stmt->bindParam(':name', $stmt_data['name']);
    $stmt->bindParam(':surname', $stmt_data['surname']);
    $stmt->bindParam(':username', $stmt_data['username']);
    $stmt->bindParam(':role', $stmt_data['role']);

    $stmt_data['password'] = md5($stmt_data['password']);
    $stmt->bindParam(':password', $stmt_data['password']);

    try {
        $stmt->execute();
        echo "created";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function update_user($stmt_data) {
    global $db;
    $pdo = $db->Connect();
    $stmt = $pdo->prepare("UPDATE users SET name=:name, surname=:surname, username=:username, role=:role, password=:password WHERE id=:id");

    $stmt->bindParam(':name', $stmt_data['name']);
    $stmt->bindParam(':surname', $stmt_data['surname']);
    $stmt->bindParam(':username', $stmt_data['username']);
    $stmt->bindParam(':role', $stmt_data['role']);

    $stmt_data['password'] = md5($stmt_data['password']);
    $stmt->bindParam(':password', $stmt_data['password']);
    $stmt->bindParam(':id', $stmt_data['id']);

    try {
        $stmt->execute();
        echo "updated";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function delete_user($stmt_data) {
    global $db;
    $pdo = $db->Connect();
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(':id', $stmt_data['id']);

    try {
        $stmt->execute();
        echo "deleted";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function read_user($stmt_data) {
    global $db;
    $pdo = $db->Connect();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $stmt_data['id']);

    try {
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
