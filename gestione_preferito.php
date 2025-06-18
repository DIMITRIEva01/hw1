<?php
require_once 'dbconfig.php';
header('Content-Type: application/json');

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
if (!$conn) {
    echo json_encode(['ok' => false, 'errore' => 'Connessione al database fallita']);
    exit;
}

if (!isset($_POST['user_id'], $_POST['manga_id'], $_POST['titolo'], $_POST['copertina_url'])) {
    echo json_encode(['ok' => false, 'errore' => 'Dati mancanti']);
    exit;
}

$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
$manga_id = mysqli_real_escape_string($conn, $_POST['manga_id']);
$titolo = mysqli_real_escape_string($conn, $_POST['titolo']);
$copertina_url = mysqli_real_escape_string($conn, $_POST['copertina_url']);

// Controlla se esiste già
$check = mysqli_query($conn, "SELECT * FROM preferiti WHERE user_id = '$user_id' AND manga_id = '$manga_id'");

if (mysqli_num_rows($check) > 0) {
    // Rimuovi
    $query = "DELETE FROM preferiti WHERE user_id = '$user_id' AND manga_id = '$manga_id'";
    $azione = 'rimosso';
} else {
    // Aggiungi
    $query = "INSERT INTO preferiti (user_id, manga_id, titolo, copertina_url) VALUES ('$user_id', '$manga_id', '$titolo', '$copertina_url')";
    $azione = 'aggiunto';
}

if (mysqli_query($conn, $query)) {
    echo json_encode(['ok' => true, 'azione' => $azione]);
} else {
    echo json_encode(['ok' => false, 'errore' => mysqli_error($conn)]);
}

mysqli_close($conn);
?>
