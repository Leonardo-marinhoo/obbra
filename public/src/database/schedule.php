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
    $query = $json_data['query'];

    switch ($query) {
        case ('fetch_folders'):
            $stmt_data = $json_data['stmt_data'];
            fetch_folders($pdo,$stmt_data['parent_id']);
            break;

        case ('create_folder'):
            $stmt_data = $json_data['stmt_data'];

            create_folder(
                pdo: $pdo,
                folder_name: $stmt_data['folder_name'],
                parent_id: $stmt_data['parent_id'],
                description: $stmt_data['description'],
            );
            break;


        case ('delete_folder'):
            $stmt_data = $json_data['stmt_data'];
            delete_folder(pdo: $pdo, id: $stmt_data['id']);
            break;

        case ('edit_folder_name'):
            $stmt_data = $json_data['stmt_data'];
            edit_folder_name(pdo: $pdo, id: $stmt_data['id'], folder_name: $stmt_data['folder_name']);
            break;

        case ('update_folder_status'):
            $stmt_data = $json_data['stmt_data'];
            update_folder_status(pdo: $pdo, id: $stmt_data['id'], status: $stmt_data['status']);
            break;

        case ('read_folder'):
            $stmt_data = $json_data['stmt_data'];
            read_folder(pdo: $pdo, id: $stmt_data['id']);
            break;

        case ('create_pendencia'):
            $stmt_data = $json_data['stmt_data'];

            create_pendencia(
                pdo: $pdo,
                pendencia_name: $stmt_data['pendencia_name'],
                pendencia_description: $stmt_data['pendencia_description'],
                folder_id: $stmt_data['folder_id'],
            );
            break;

        case ('fetch_pendencia'):
            fetch_pendencia($pdo);
            break;

        case ('update_pendencia_status'):
            $stmt_data = $json_data['stmt_data'];
            update_pendencia_status(pdo: $pdo, id: $stmt_data['id'], status: $stmt_data['status']);
            break;

        case ('fetch_child_pendencia'):
            $stmt_data = $json_data['stmt_data'];
            fetch_child_pendencia(pdo:$pdo, folder_id:$stmt_data['folder_id']);
            break;

    }
}

function fetch_folders($pdo, $parent_id)
{
    $sql = "SELECT * FROM pendencia_folder where parent_id = :parent_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':parent_id', $parent_id);
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

// Função para criar uma nova pasta
function create_folder($pdo, $folder_name, $parent_id, $description)
{
    // Preparar a consulta SQL usando prepared statements
    $sql = "INSERT INTO pendencia_folder (id, folder_name, parent_id, description,status) 
    VALUES (null, :folder_name, :parent_id, :description, null)";
    $stmt = $pdo->prepare($sql);

    // Vincular os valores aos parâmetros
    $stmt->bindParam(':folder_name', $folder_name);
    $stmt->bindParam(':parent_id', $parent_id);
    $stmt->bindParam(':description', $description);


    // Executar a consulta SQL e retornar o resultado
    if ($stmt->execute()) {
        echo json_encode($pdo->lastInsertId());
    } else {
        return false;
    }
}

function read_folder($pdo, $id) 
{
    $sql = 'SELECT * FROM pendencia_folder where id=:id';
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $id);

    try {
        $stmt->execute();
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    } catch (PDOException $e) {
        echo json_encode($e->getMessage());
    }
}

// Função para atualizar o status da pasta
function update_folder_status($pdo, $id, $status)
{
    // Preparar a consulta SQL usando prepared statements
    $sql = "UPDATE pendencia_folder SET status = :status WHERE id = :id";
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

// Função para deletar a pasta
function delete_folder($pdo, $id)
{
    // Preparar a consulta SQL usando prepared statements
    $sql = "DELETE FROM pendencia_folder WHERE id = :id";
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

// Função para editar o nome da pasta
function edit_folder_name($pdo, $id, $folder_name)
{
    // Preparar a consulta SQL usando prepared statements
    $sql = "UPDATE pendencia_folder SET folder_name = :folder_name WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    // Vincular os valores aos parâmetros
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':folder_name', $folder_name);

    // Executar a consulta SQL e retornar o resultado
    if ($stmt->execute()) {
        echo json_encode(array("response" => "updated"));
    } else {
        echo json_encode("error");
    }
}



/////////////////////////////////////////////tasks //


function create_pendencia($pdo, $pendencia_name, $pendencia_description, $folder_id)
{
    // Preparar a consulta SQL usando prepared statements
    $sql = "INSERT INTO pendencia_item (id, folder_id, pendencia_name, description, status) 
    VALUES (null, :folder_id, :pendencia_name, :description, 'Em Progresso')";
    $stmt = $pdo->prepare($sql);

    // Vincular os valores aos parâmetros
    $stmt->bindParam(':folder_id', $folder_id);
    $stmt->bindParam(':pendencia_name', $pendencia_name);
    $stmt->bindParam(':description', $pendencia_description);
    // Executar a consulta SQL e retornar o resultado
    if ($stmt->execute()) {
        echo json_encode($pdo->lastInsertId());
    } else {
        return false;
    }
}
function fetch_pendencia($pdo)
{
    $sql = "SELECT * FROM pendencia_item";
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
function update_pendencia_status($pdo, $id, $status)
{
    // Preparar a consulta SQL usando prepared statements
    $sql = "UPDATE pendencia_item SET status = :status WHERE id = :id";
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

function fetch_child_pendencia($folder_id, $pdo)
{
    $sql = "SELECT * FROM pendencia_item where folder_id = :folder_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':folder_id', $folder_id);
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
