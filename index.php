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
function selectAluno($id, $nome, $idade)
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

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0){
            foreach ($result as $aluno){
                echo "\n";
                printf($format, $aluno['id'], $aluno['nome'], $aluno['idade']);
            }
        }else{
            echo "\nRegistro não encontrado";
        }
      
        echo "\n";

    } catch (PDOException $error) {
        echo "\nFalha ao listar Alunos, erro: {$error->getMessage()}";
    }
}

// --- TERMINAL ADICIONAL ALUNO ---
function terminaAddAluno()
{
    $nome = "";
    $idade = "";
    
    echo "\nPor favor informe o nome do aluno:";
    $handle = fopen("php://stdin", "r");
    $nome = trim(fgets($handle));

    echo "\nPor favor informe a idade:";
    $handle = fopen("php://stdin", "r");
    $idade = trim(fgets($handle));
    
    insertAluno($nome, $idade);
}

// --- TERMINAL ATUALIZAR ALUNO ---
function terminalUpaluno()
{   
    selectAluno(null, null, null);
    $id = "";
    $nome = "";
    $idade = "";

    echo "\nPor favor informe o ID do aluno que deseja Atualizar: ";
    $handle = fopen("php://stdin", "r");
    $id = trim(fgets($handle));

    echo "\nPor favor informe o NOME do aluno que deseja Atualizar: ";
    $handle = fopen("php://stdin", "r");
    $nome = trim(fgets($handle));

    echo "\nPor favor informe o IDADE do aluno que deseja Atualizar: ";
    $handle = fopen("php://stdin", "r");
    $idade = trim(fgets($handle));

    updateAluno($id, $nome, $idade);
}

// --- TERMINAL EXCLUIR ALUNO ---
function terminalDelAluno()
{
    selectAluno(null, null, null);
    $id = "";
    echo "\nInforme o ID do aluno a ser removido: ";
    $handle = fopen("php://stdin", "r");
    $id = trim(fgets($handle));

    deleteAluno($id);
}

// --- TERMINAL SELECIONAR ALUNOS ---
function terminalSelectAluno()
{
    $id = null;
    $nome = null;
    $idade = null;

    echo "\n\n\n**** Escolha o tipo de pesquisa ****";
    echo "\nDigite 1 para buscar pelo ID do aluno";
    echo "\nDigite 2 para buscar pelo NOME do aluno";
    echo "\nDigite 3 para buscar pela IDADE do aluno";
    echo "\nDigite 4 para buscar pelo NOME e a IDADE do aluno";
    echo "\nDigite 5 para Listar os alunos\n";
    
    echo "Opção: ";    
    $handle = fopen("php://stdin", "r");
    $line = trim(fgets($handle));

    switch ($line) {
        case '1':
            echo "\nInforme o ID do aluno: ";
            $handle = fopen("php://stdin", "r");
            $id = trim(fgets($handle));
            selectAluno($id, $nome, $idade);
            fclose($handle);
            break;

        case '2':
            echo "\nInforme o NOME do aluno: ";
            $handle = fopen("php://stdin", "r");
            $nome = trim(fgets($handle));
            selectAluno($id, $nome, $idade);
            fclose($handle);
            break;

        case '3':
            echo "\nInforme o IDADE do aluno: ";
            $handle = fopen("php://stdin", "r");
            $idade = trim(fgets($handle));
            selectAluno($id, $nome, $idade);
            fclose($handle);
            break;
        
        case '4':
            echo "\nInforme o NOME do aluno: ";
            $handle = fopen("php://stdin", "r");
            $nome = trim(fgets($handle));
            
            echo "\nInforme o IDADE do aluno: ";
            $handle = fopen("php://stdin", "r");
            $idade = trim(fgets($handle));

            selectAluno($id, $nome, $idade);
            fclose($handle);
            break;
        
        case '5':
            selectAluno($id, $nome, $idade);
            fclose($handle);
            break;

        default:
            # code...
            break;
    }

    
}


function menu()
{
    echo "\n\n\n**** Bem vindo ao sistema CRUD de Alunos ****";
    echo "\nDigite 1 para Incluir alunos";
    echo "\nDigite 2 para Atualizar alunos";
    echo "\nDigite 3 para Excluir alunos";
    echo "\nDigite 4 para Listar alunos";
    echo "\nDigite 5 para Sair\n";

    echo "Opção: ";
    $handle = fopen("php://stdin", "r");
    $line = trim(fgets($handle));

    switch ($line){
        case '1':
            terminaAddAluno();
            fclose($handle);
            menu();
            break;

        case '2':
            terminalUpaluno();
            fclose($handle);
            menu();
            break;

        case '3':
            terminalDelAluno();
            fclose($handle);
            menu();
            break;
        
        case '4':
            terminalSelectAluno();
            menu();
            break;

        case '5':
            echo "\nObrigado por usar o sistema de alunos, volte sempre.";
            fclose($handle);
            break;
        
        default:
        echo "\nOpção Invalida, selecione uma opção valida:";
            fclose($handle);
            menu();
            break;
        
    }
}

menu();