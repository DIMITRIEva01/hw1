<?php
require_once 'auth.php';
require_once 'dbconfig.php';

header('Content-Type: application/json');


if (!$userid = checkAuth()) {
    echo json_encode(['error' => 'Non autorizzato']);
    exit;
}

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

if (!$conn) {
    echo json_encode(['error' => 'Connessione al database fallita']);
    exit;
}
$userid = mysqli_real_escape_string($conn, $userid); 
$query = "SELECT titolo, copertina_url, prezzo FROM carrello WHERE user_id = $userid";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(['error' => 'Errore nella query']);
    mysqli_close($conn);
    exit;
}

$items = [];

while ($row = mysqli_fetch_assoc($result)) {
    $items[] = [
        'titolo' => htmlspecialchars($row['titolo']),
        'copertina_url' => htmlspecialchars($row['copertina_url']),
        'prezzo' => number_format((float)$row['prezzo'], 2)
    ];
}

echo json_encode([
    'authenticated' => true,
    'items' => $items
]);

mysqli_close($conn);
?>
