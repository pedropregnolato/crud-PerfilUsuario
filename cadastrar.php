<?php
session_start();
include_once './conexao.php';

?>
<form action="cadastrar.php" method="POST" enctype="multipart/form-data">
    <p>Nome: <input type="text" name="nome" placeholder="Digite o Nome" maxlength="50" required></p>
    <p>Clique para <input type="file" name="foto" required></p>
    <p>Documento: <input type="tel" name="documento" placeholder=" .  .  -" maxlength="14" required></p>
    <p>Telefone: <input type="tel" name="telefone" placeholder="() - " maxlength="14" required></p>
    <p>Email: <input type="email" name="email" placeholder="example@mail.com" maxlength="50" required></p>
    <input type="submit" name="cadastrar" value="Cadastrar"><br>
</form>

<button><a href="index.php">voltar</a></button>
</body>
<?php

//insert
if (isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $nome = strtoupper($nome);
    $documento = $_POST['documento'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $foto = $_FILES['foto']['name'];

    if (!empty($nome) && !empty($documento) && !empty($telefone) && !empty($email) && !empty($foto)) {
        $query = "INSERT INTO cadastro(nome, documento, telefone, email, foto) VALUES (:nome, :documento, :telefone, :email, :foto)";
        $executar = $conexao->prepare($query);
        $executar->bindParam(':nome', $nome);
        $executar->bindParam(':documento', $documento);
        $executar->bindParam(':telefone', $telefone);
        $executar->bindParam(':email', $email);
        $executar->bindParam(':foto', $foto);

        $return = $executar->execute();
        if ($return) {

            $salvar_id = $conexao->lastInsertId();

            $diretorio = 'fotos/' . $salvar_id . "/";

            mkdir($diretorio, 0755);

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $diretorio . $_FILES['foto']['name'])) {
                $_SESSION['success'] = "Cadastro realizado!";
                header('Location: index.php');
            }
        } else {
            $_SESSION['status'] = "Ocorreu um erro. Cadastro não realizado!";
            header('Location: index.php');
        }
    } else {
        $_SESSION['status'] = "Preencha todos os campos!";
        header('Location: cadastrar.php');
    }
}
