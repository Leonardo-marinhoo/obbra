<?php

require_once('./database.php');

// Criar uma instância da classe Database
$db = new Database();
// Conectar ao banco de dados usando a função connect
$pdo = $db->Connect();

$content_type = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';
if ($content_type === 'application/json') {
    $json_content = trim(file_get_contents("php://input"));
    $json_data = json_decode($json_content, true); //true = ARRAY (acessivel por index [param]), false = JSON (acessivel por seta ->)
    $action = $json_data['action'];
    // echo ($json_data['stmt_data']['task_name']);
    switch ($action) {
        case ('fetchSchedule'):
            fetchSchedule($pdo);
            break;

        case ('createSchedule'):
            $stmt_data = $json_data['stmt_data'];

            createSchedule(
                pdo: $pdo,
                schedule_name: $stmt_data['schedule_name'],
                description: $stmt_data['description'],
                start_date: $stmt_data['start_date'],
                end_date: $stmt_data['end_date'],
                status: $stmt_data['status'],
                manager_id: $stmt_data['manager_id'],
                members_id: $stmt_data['members_id']
            );
            break;


        case ('deleteSchedule'):
            $stmt_data = $json_data['stmt_data'];
            deleteSchedule(pdo: $pdo, id: $stmt_data['id']);
            break;

        case ('editScheduleName'):
            $stmt_data = $json_data['stmt_data'];
            editScheduleName(pdo: $pdo, id: $stmt_data['id'], schedule_name: $stmt_data['schedule_name']);
            break;

        case ('updateScheduleStatus'):
            $stmt_data = $json_data['stmt_data'];
            updateScheduleStatus(pdo: $pdo, id: $stmt_data['id'], status: $stmt_data['status']);
            break;

        case ('getSchedule'):
            $stmt_data = $json_data['stmt_data'];
            getSchedule(pdo: $pdo, id: $stmt_data['id']);
            break;

        case ('createTask'):
            $stmt_data = $json_data['stmt_data'];

            createTask(
                pdo: $pdo,
                task_name: $stmt_data['task_name'],
                task_description: $stmt_data['task_description'],
                schedule_id: $stmt_data['schedule_id'],
            );
            break;

        case ('fetchTask'):
            fetchTask($pdo);
            break;

        case ('update_task_status'):
            $stmt_data = $json_data['stmt_data'];
            updateTaskStatus(pdo: $pdo, id: $stmt_data['id'], status: $stmt_data['status']);
            break;

        case ('fetchChildTask'):
            $stmt_data = $json_data['stmt_data'];
            fetchChildTask(pdo:$pdo, schedule_id:$stmt_data['schedule_id']);
            break;

    }
}

function fetchSchedule($pdo)
{
    $sql = "SELECT * FROM cronogramas";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }
        ;
        echo json_encode($result);

    } catch (PDOexception $e) {
        echo json_encode("error");
    }
}

// Função para criar um novo cronograma
function createSchedule($pdo, $schedule_name, $description, $start_date, $end_date, $status, $manager_id, $members_id)
{
    // Preparar a consulta SQL usando prepared statements
    $sql = "INSERT INTO cronogramas (id, schedule_name, description, start_date, end_date, status, manager_id, members_id) 
    VALUES (null, :schedule_name, :description, :start_date, :end_date, :status, :manager_id, :members_id)";
    $stmt = $pdo->prepare($sql);

    // Vincular os valores aos parâmetros
    $stmt->bindParam(':schedule_name', $schedule_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':manager_id', $manager_id);
    $stmt->bindParam(':members_id', $members_id);

    // Executar a consulta SQL e retornar o resultado
    if ($stmt->execute()) {
        echo json_encode($pdo->lastInsertId());
    } else {
        return false;
    }
}

function getSchedule($pdo, $id)
{
    $sql = 'SELECT * FROM cronogramas where id=:id';
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $id);

    try {
        $stmt->execute();
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
        echo json_encode($e->getMessage());
    }
}

// Função para atualizar o status do cronograma
function updateScheduleStatus($pdo, $id, $status)
{
    // Preparar a consulta SQL usando prepared statements
    $sql = "UPDATE cronogramas SET status = :status WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    // Vincular os valores aos parâmetros
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':status', $status);

    // Executar a consulta SQL e retornar o resultado
    if ($stmt->execute()) {
        echo json_encode(array("response" => "updated"));
    } else {
        echo json_encode("error");
    }
}

// Função para deletar o cronograma
function deleteSchedule($pdo, $id)
{
    // Preparar a consulta SQL usando prepared statements
    $sql = "DELETE FROM cronogramas WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    // Vincular os valores aos parâmetros
    $stmt->bindParam(':id', $id);

    // Executar a consulta SQL e retornar o resultado
    if ($stmt->execute()) {
        echo json_encode(array("response" => "deleted"));
    } else {
        echo json_encode("error");
    }
}

// Função para editar o nome do cronograma
function editScheduleName($pdo, $id, $schedule_name)
{
    // Preparar a consulta SQL usando prepared statements
    $sql = "UPDATE cronogramas SET schedule_name = :schedule_name WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    // Vincular os valores aos parâmetros
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':schedule_name', $schedule_name);

    // Executar a consulta SQL e retornar o resultado
    if ($stmt->execute()) {
        echo json_encode(array("response" => "updated"));
    } else {
        echo json_encode("error");
    }
}

// Função para editar members_id do cronograma
function editScheduleMembers($pdo, $id, $members_id)
{
    // Preparar a consulta SQL usando prepared statements
    $sql = "UPDATE cronogramas SET members_id = :members_id WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    // Vincular os valores aos parâmetros
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':members_id', $members_id);

    // Executar a consulta SQL e retornar o resultado
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

/////////////////////////////////////////////tasks //


function createTask($pdo, $task_name, $task_description, $schedule_id)
{
    // Preparar a consulta SQL usando prepared statements
    $sql = "INSERT INTO atividades (id, schedule_id, task_name, description, status, start_date) 
    VALUES (null, :schedule_id, :task_name, :description, 'Em Progresso', null)";
    $stmt = $pdo->prepare($sql);

    // Vincular os valores aos parâmetros
    $stmt->bindParam(':schedule_id', $schedule_id);
    $stmt->bindParam(':task_name', $task_name);
    $stmt->bindParam(':description', $task_description);
    // Executar a consulta SQL e retornar o resultado
    if ($stmt->execute()) {
        echo json_encode($pdo->lastInsertId());
    } else {
        return false;
    }
}
function fetchTask($pdo)
{
    $sql = "SELECT * FROM atividades";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }
        ;
        echo json_encode($result);

    } catch (PDOexception $e) {
        echo json_encode("error");
    }
}
function updateTaskStatus($pdo, $id, $status)
{
    // Preparar a consulta SQL usando prepared statements
    $sql = "UPDATE atividades SET status = :status WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    // Vincular os valores aos parâmetros
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':status', $status);

    // Executar a consulta SQL e retornar o resultado
    if ($stmt->execute()) {
        echo json_encode(array("response" => "updated"));
    } else {
        echo json_encode("error");
    }
}

function fetchChildTask($schedule_id, $pdo)
{
    $sql = "SELECT * FROM atividades where schedule_id = :schedule_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':schedule_id', $schedule_id);
    try {
        $stmt->execute();
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }
        echo json_encode($result);

    } catch (PDOexception $e) {
        echo json_encode("error");
    }
}
