<?php

//--- PDO / CONEXÃO ---
try{
    $bdPath = __DIR__ . "/banco.sqlite";
    $connection =  new PDO('sqlite:' . $bdPath);
    $connection->getAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $error){
        echo "Não foi possível se conectar ao banco, erro: " . $error->getMessage();
    }

//--- DELETE ---
/*$queryDelete = 'DELETE FROM alunos WHERE id = :id';
$stmt = $connection->prepare($queryDelete);
$stmt->bindValue(':id', $id);
$stmt->execute();*/

//--- UPDATE ---
/*$queryUpdate = 'UPDATE alunos SET name = :name, idade = :idade WHERE id = :id;';
$stmt = $connection->prepare($queryUpdate);
$stmt->bindValue(':id', 5);
$stmt->bindValue(':name', 'Jefferson Clemente');
$stmt->bindValue(':idade', 34);
$stmt->execute();*/

//--- INSERT ---
/*$queryInsert = 'INSERT INTO alunos (name, idade) VALUES (:name, :idade);';
$stmt = $connection->prepare($queryInsert);
$stmt->bindValue(':name', 'Jeffferson Clemente');
$stmt->bindValue(':idade', 34);
$stmt->execute();*/


//--- SELECT ---
$querySelect = 'SELECT * FROM alunos';
$stmt = $connection->prepare($querySelect);
$stmt->execute();

var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));