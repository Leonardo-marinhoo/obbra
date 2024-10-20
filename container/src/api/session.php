<?php
require_once('database.php');
session_start();

$request = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';

$db = new Database();

if ($request === "application/json") {
    $request_data = trim(file_get_contents("php://input"));
    $decoded_data = json_decode($request_data, true);
    $request_type = $decoded_data['request_type'];

    switch ($request_type) {
        case ('get_session'):
            get_session();
            break;
        case ('logout'):
            logout();
            break;
    }
}

function get_session() {
    // Inicia a sessão, se ainda não estiver iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Verifica se existem valores na sessão
    if (!empty($_SESSION)) {
        // Imprime todos os valores da sessão
        echo json_encode($_SESSION);
    } else {
        echo 'Nenhuma variável de sessão configurada.';
    }
}

function logout() {
    // Inicia a sessão, se ainda não estiver iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Limpa todas as variáveis de sessão
    $_SESSION = array();

    // Destrói a sessão
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destrói a sessão
    session_destroy();

    // Retorna uma resposta JSON indicando que o logout foi bem-sucedido
    echo json_encode(['status' => 'logout_success']);
}
?>
