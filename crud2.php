<?php

// --- CONEXAO ---
try {
    $bdpath = __DIR__ . '/banco.sqlite';
    $con = new PDO('sqlite:' . $bdpath);
} catch (PDOException $error) {
    echo "\nNão foi possível se conectar ao banco, erro: {$error->getMessage()}";
}

// --- INSERT ---
function insertAluno($nome, $idade)
{
    global $con;
    try {
        $queryInsert = 'INSERT INTO alunos (nome, idade) VALUES (:nome, :idade);';
        $stmt = $con->prepare($queryInsert);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':idade', $idade);
        $stmt->execute();
        echo "\nAluno incluso com sucesso!";
    } catch (PDOException $error) {
        echo "\nNão foi possível inserir aluno, erro:  {$error->getMessage()}";
    }
}

// --- UPDATE ---
function updateAluno($id, $nome, $idade)
{
    global $con;
    try {
        $queryUpdate = 'UPDATE alunos SET nome = :nome, idade = :idade WHERE id = :id;';
        $stmt = $con->prepare($queryUpdate);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':idade', $idade);
        $stmt->execute();
        echo "\nAluno atualizado com sucesso!";
    } catch (PDOException $error) {
        echo "\nNão foi possível alterar aluno, erro: {$error->getMessage()}";
    }
}

// --- DELETE ---
function deleteAluno($id)
{
    global $con;
    try {
        $queryDelete = 'DELETE FROM alunos where id = :id';
        $stmt = $con->prepare($queryDelete);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo "\nAluno removido com sucesso!";
    } catch (PDOException $error) {
        echo "\nNão foi possível excluir o registro, erro: {$error->getMessage()}";
    }


}

// --- SELECT ---
function selectAlunos()
{
    global $con;
    try {
        $querySelect = 'SELECT * FROM alunos;';
        $stmt = $con->prepare($querySelect);
        $stmt->execute();
        var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $error) {
        echo "\nNão foi possível listar alunos, erro: {$error->getMessage()}";
    }
    
}

//insertAluno('Tiago Gonçalves', '29');
//updateAluno(3, 'Humberto Pinto', 24);
//selectAluno(null, 'Tiago', null);