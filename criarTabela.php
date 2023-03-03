<?php

// --- CONEXAO ---
try {
    $bdpath = __DIR__ . '/banco.sqlite';
    $con = new PDO('sqlite:' . $bdpath);
} catch (PDOException $error) {
    echo 'Não foi possível se conectar ao banco, erro: ' . $error->getMessage();
}

$con->exec('CREATE TABLE alunos (id INTEGER PRIMARY KEY, nome TEXT, idade TEXT);');
