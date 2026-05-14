<?php
try {
    $conn = new PDO(
        "sqlsrv:Server=" . getenv('DB_SERVER') . ";Database=" . getenv('DB_NAME'),
        getenv('DB_USER'),
        getenv('DB_PASSWORD'),
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    $conn = null;
}