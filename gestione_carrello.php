<?php
require_once 'dbconfig.php';
header('Content-Type: application/json');

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
if (!$conn) {
    echo json_encode(['ok' => false, 'errore' => 'Connessione al database fallita']);
    exit;
}

if (!isset($_POST['user_id'], $_POST['manga_id'], $_POST['titolo'], $_POST['copertina_url'],$_POST['prezzo'])) {
    echo json_encode(['ok' => false, 'errore' => 'Dati mancanti']);
    exit;
}

$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
$manga_id = mysqli_real_escape_string($conn, $_POST['manga_id']);
$titolo = mysqli_real_escape_string($conn, $_POST['titolo']);
$copertina_url = mysqli_real_escape_string($conn, $_POST['copertina_url']);
$prezzo = mysqli_real_escape_string($conn, $_POST['prezzo']);

$check_query = "SELECT id FROM carrello WHERE user_id = '$user_id' AND manga_id = '$manga_id'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    echo json_encode(['ok' => false, 'errore' => 'Il manga è già nel carrello']);
    mysqli_close($conn);
    exit;
}

$query = "INSERT INTO carrello (user_id, manga_id, titolo, copertina_url,prezzo) VALUES ('$user_id', '$manga_id', '$titolo', '$copertina_url', '$prezzo')";

if (mysqli_query($conn, $query)) {
    echo json_encode(['ok' => true]);
} else {
    echo json_encode(['ok' => false, 'errore' => mysqli_error($conn)]);
}

mysqli_close($conn);
?>