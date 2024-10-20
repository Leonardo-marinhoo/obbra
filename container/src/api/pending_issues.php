<?php
require_once('database.php');

$request = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

$db = new Database();

if ($request === "application/json") {
    $request_data = trim(file_get_contents("php://input"));
    $decoded_data = json_decode($request_data, true);
    $request_type = $decoded_data['request_type'];

    switch ($request_type) {
        case ('update_pendency'):
            update_pendency($decoded_data['stmt_data']);
            break;
        case ('update_priority'):
            update_priority($decoded_data['stmt_data']);
            break;
        case ('update_status'):
            update_status($decoded_data['stmt_data']);
            break;
        case ('update_status_vistoria'):
            update_status_vistoria($decoded_data['stmt_data']);
            break;
        case ('create_pendency'):
            create_pendency($decoded_data['stmt_data']);
            break;
        case ('create_vistoria'):
            create_vistoria($decoded_data['stmt_data']);
            break;
        case ('delete_pendency'):
            delete_pendency($decoded_data['stmt_data']);
            break;
    }
}

function update_pendency($stmt_data)
{
    global $db;
    $pdo = $db->Connect();
    $stmt = $pdo->prepare("UPDATE pending_issues SET subject=:subject,
     description=:description, status=:status, priority=:priority,
      department_id=:department_id, user_id=:user_id, date_created=:date_created, obra=:obra WHERE id=:id");

    $stmt->bindParam(":subject", $stmt_data['subject']);
    $stmt->bindParam(":description", $stmt_data['description']);
    $stmt->bindParam(":status", $stmt_data['status']);
    $stmt->bindParam(":priority", $stmt_data['priority']);
    $stmt->bindParam(":department_id", $stmt_data['department_id']);
    $stmt->bindParam(":user_id", $stmt_data['user_id']);
    $stmt->bindParam(":date_created", $stmt_data['date_created']);
    $stmt->bindParam(":obra", $stmt_data['obra']);
    $stmt->bindParam(":id", $stmt_data['id']);



    try {
        $stmt->execute();
        echo "OK";
    } catch (PDOException $e) {
        echo $e;
    }
}
function update_priority($stmt_data)
{
    global $db;
    $pdo = $db->Connect();
    $stmt = $pdo->prepare("UPDATE pending_issues SET priority=:priority WHERE id=:id");
    $stmt->bindParam(":priority", $stmt_data['priority']);
    $stmt->bindParam(":id", $stmt_data['id']);

    try {
        $stmt->execute();
        echo "Ok priority";
    } catch (PDOException $e) {
        echo $e;
    }
}
function update_status($stmt_data)
{
    global $db;
    $pdo = $db->Connect();
    $stmt = $pdo->prepare("UPDATE pending_issues SET status=:status WHERE id=:id");
    $stmt->bindParam(":status", $stmt_data['status']);
    $stmt->bindParam(":id", $stmt_data['id']);

    try {
        $stmt->execute();
        echo $stmt_data['status'];
    } catch (PDOException $e) {
        echo $e;
    }
}
function update_status_vistoria($stmt_data)
{
    global $db;
    $pdo = $db->Connect();
    $field = $stmt_data['field'];

    // Certifique-se de que o nome da coluna é seguro para uso na consulta
    // $allowed_fields = ['limpeza', 'pintura'];
    // if (!in_array($field, $allowed_fields)) {
    //     throw new Exception('Campo inválido fornecido.');
    // }

    // Construa a consulta SQL dinamicamente
    $sql = "UPDATE vistorias SET $field=:status WHERE id=:id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":status", $stmt_data['status']);
    $stmt->bindParam(":id", $stmt_data['id']);

    try {
        $stmt->execute();
        echo $stmt_data['status'];
    } catch (PDOException $e) {
        echo $e;
    }
}

function delete_pendency($stmt_data)
{
    global $db;
    $pdo = $db->Connect();
    $stmt = $pdo->prepare("DELETE FROM pending_issues WHERE id=:id");
    $stmt->bindParam(":id", $stmt_data['id']);

    try {
        $stmt->execute();
        echo "OK";
    } catch (PDOException $e) {
        echo $e;
    }
}
function create_pendency($stmt_data)
{
    global $db;
    $pdo = $db->Connect();

    // Declarando a consulta SQL com os nomes das colunas especificados
    $stmt = $pdo->prepare("INSERT INTO pending_issues (subject, description, status, priority, department_id, user_id, date_created, obra)
    VALUES (:subject, :description, :status, :priority, :department_id, :user_id, NOW(), :obra)");

    // Corrigindo o erro de digitação no nome do parâmetro
    $stmt->bindParam(":subject", $stmt_data['subject']);
    $stmt->bindParam(":description", $stmt_data['description']); // Corrigido de 'idescriptiond' para 'description'
    $stmt->bindParam(":status", $stmt_data['status']);
    $stmt->bindParam(":priority", $stmt_data['priority']);
    $stmt->bindParam(":department_id", $stmt_data['department_id']);
    $stmt->bindParam(":user_id", $stmt_data['user_id']);
    $stmt->bindParam(":obra", $stmt_data['obra']);

    try {
        $stmt->execute();
        echo "OK";
    } catch (PDOException $e) {
        var_dump($stmt_data);
        echo "Error: " . $e->getMessage();
    }
}
function create_vistoria($stmt_data)
{
    global $db;
    $pdo = $db->Connect();

    // Declarando a consulta SQL com os nomes das colunas especificados
    $stmt = $pdo->prepare("INSERT INTO vistorias (apto, pintura, eletrica, limpeza, metais)
    VALUES (:apto, 0, 0, 0, 0)");

    $stmt->bindParam(":apto", $stmt_data['apto']);

    try {
        $stmt->execute();
        echo "OK";
    } catch (PDOException $e) {
        var_dump($stmt_data);
        echo "Error: " . $e->getMessage();
    }
}
