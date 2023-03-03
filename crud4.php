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
function selectAluno($id=null, $nome=null, $idade=null)
{
    global $con;
    try {
        $querySelect = 'SELECT * FROM alunos';
        $where = "";

        if($nome){$where .=" WHERE nome LIKE '%{$nome}%'";}
        if($id){$where .= ($where?" and ":" where ") . " id = {$id} ";}
        if($idade){$where .= ($where?" and ":" where ") . " idade = {$idade} ";}
        $querySelect .= $where;
        
        $stmt = $con->prepare($querySelect);
        $stmt->execute();

        $format = "|%5.5s| %-30.30s | %-10.5s|";
        echo "\n";
        printf($format, 'ID', 'NOME', 'IDADE');

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $aluno){
            echo "\n";
            printf($format, $aluno['id'], $aluno['nome'], $aluno['idade']);
            
        }
        echo "\n";

    } catch (PDOException $error) {
        echo "\nFalha ao listar Alunos, erro: {$error->getMessage()}";
    }
}

echo "\n\n\n**** Bem vindo ao sistema CRUD de Alunos ****\n";
//updateAluno(3, 'Humberto Melo', '22');
selectAluno(null, null, null);