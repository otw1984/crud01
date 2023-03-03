<?php

//--- PDO / CONEXÃO ---
try {
    $bdPath = __DIR__ . "/banco.sqlite";
    $connection =  new PDO('sqlite:' . $bdPath);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    echo "Não foi possível se conectar ao banco, erro: " . $error->getMessage();
}

//--- DELETE ---
function deleteAluno($id)
{
    global $connection;
    try {
        $queryDelete = 'DELETE FROM alunos WHERE id = :id';
        $stmt = $connection->prepare($queryDelete);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    } catch (PDOException $error) {
        echo "Não foi possível remover o registro, erro: " . $error->getMessage();
    }
}

//--- UPDATE ---
function updateAluno($id, $name, $idade)
{
    global $connection;
    try{
        $queryUpdate = 'UPDATE alunos SET name = :name, idade = :idade WHERE id = :id;';
        $stmt = $connection->prepare($queryUpdate);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':idade', $idade);
        $stmt->execute();
    } catch (PDOException $error) {
        echo "Não foi possível editar o registro, erro: " . $error->getMessage();
    }
}

//--- INSERT ---
function insertAluno($name, $idade)
{
    global $connection;
    try{
        $queryInsert = 'INSERT INTO alunos (name, idade) VALUES (:name, :idade);';
        $stmt = $connection->prepare($queryInsert);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':idade', $idade);
        $stmt->execute();
    } catch (PDOException $error) {
        echo "Não foi possivel inserir o registro no banco, erro: " . $error->getMessage();
    }
}

//--- SELECT ---
function selectAlunos()
{
    global $connection;
    try{
        $querySelect = 'SELECT * FROM alunos';
        $stmt = $connection->prepare($querySelect);
        $stmt->execute();
        var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));

    } catch (PDOException $error) {
        echo "Não foi possível exibir os registros, erro: " . $error->getMessage();
    }
}