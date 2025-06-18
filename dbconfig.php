<?php
    $dbconfig = [
        'host'     => '127.0.0.1',
        'name'     => 'hw1',
        'user'     => 'root',
        'password' => ''
    ];
    $connessione = new mysqli(
        $dbconfig['host'],
        $dbconfig['user'],
        $dbconfig['password'],
        $dbconfig['name']
    );
    if ($connessione->connect_error) {
        die("Connection failed: " . $connessione->connect_error);
    }
?>