<?php
require_once('./database.php');

$contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

if ($contentType === "application/json") {
    $json_content = trim(file_get_contents("php://input"));
    $json_data = json_decode($json_content, true);
    $request = $json_data['request'];

    switch ($request) {
        case ('fetch_employees'):
            fetch_employees();
            break;
        case ('extra_hour'):
            $stmt_data = $json_data['stmt_data'];
            extra_hour($stmt_data);
            break;
        case ('fetch_history'):
            fetch_history();
            break;
    }
}

function fetch_employees()
{
    $db = new Database();
    $pdo  = $db->Connect();
    $stmt = $pdo->prepare("SELECT * FROM funcionarios");

    try {
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } catch (PDOException $e) {
        echo $e;
    }
}
function fetch_history()
{
    $db = new Database();
    $pdo  = $db->Connect();
    $stmt = $pdo->prepare("SELECT * FROM hora_extra");

    try {
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } catch (PDOException $e) {
        echo $e;
    }
}
function extra_hour($stmt_data)
{
    // $employe_id, $employe_name, $employe_function, $hours, $date, $obs, $obra
    $db = new Database();
    $pdo  = $db->Connect();
    $stmt = $pdo->prepare(
        "INSERT INTO hora_extra(id,employee_id,employee_name,employee_function,employee_hours,employee_date,employee_obs,employee_obra,employee_equipe) 
    VALUES(NULL,:employee_id,:employee_name,:employee_function,:employee_hours,:employee_date,:employee_obs,:employee_obra,:employee_equipe)"
    );

    $stmt->bindParam(':employee_id', $stmt_data['employee_id']);
    $stmt->bindParam(':employee_name', $stmt_data['employee_name']);
    $stmt->bindParam(':employee_function', $stmt_data['employee_function']);
    $stmt->bindParam(':employee_hours', $stmt_data['employee_hours']);
    $stmt->bindParam(':employee_date', $stmt_data['employee_date']);
    $stmt->bindParam(':employee_obs', $stmt_data['employee_obs']);
    $stmt->bindParam(':employee_obra', $stmt_data['employee_obra']);
    $stmt->bindParam(':employee_equipe', $stmt_data['employee_equipe']);


    try {
        $stmt->execute();
        echo json_encode("201");
    } catch (PDOException $e) {
        echo $e;
    }
}

// fetch_employees();
