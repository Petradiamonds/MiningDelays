<?php
    $host = '10.110.113.15';
    $db   = 'Minmis';
    $user = 'sa';
    $pass = 'Portia+po3';

    $dsn = "sqlsrv:Server=$host;Database=$db";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::SQLSRV_ATTR_ENCODING    => PDO::SQLSRV_ENCODING_UTF8,
    ];
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
        echo 'DB_CONNECTION ERROR !';
    }
?>