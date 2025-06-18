<?php
require_once 'auth.php';

$user_id = checkAuth();

if ($user_id == 0) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'errore' => 'Utente non loggato']);
    header("Location: login.php");
    exit;
}

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
if (!$conn) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'errore' => 'Errore connessione database']);
    exit;
}

if (!ctype_digit((string)$user_id)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'errore' => 'ID utente non valido']);
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT manga_id, titolo, copertina_url,prezzo FROM carrello WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$carrello = [];
while ($row = mysqli_fetch_assoc($result)) {
    $carrello[] = $row;
}

header('Content-Type: application/json');
echo json_encode($carrello);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
