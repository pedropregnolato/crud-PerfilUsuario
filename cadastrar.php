<?php
session_start();
include_once './conexao.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <title>Criação de cadastro</title>
</head>

<body>
    <header style="margin-bottom: 3em">
        <nav class="navbar navbar-dark bg-dark justify-content-between">
            <a class="navbar-brand" href="#">Cadastrando Perfil</a>
            <a href="index.php" class="btn btn-outline-danger">voltar</a>
        </nav>
    </header>
    <main align="left" style="margin-left: 3em">
        <form action="cadastrar.php" method="POST" enctype="multipart/form-data">
            <h4>Informações</h4>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Nome</label><input type="text" name="nome" placeholder="Digite o Nome" maxlength="50" class="form-control" required>
                </div>
                <div class="form-group col-md-2">
                    <label>Documento</label><input type="tel" name="documento" placeholder=" .  .  -" maxlength="14" class="form-control" id="documento" required>
                </div>
            </div>
            <br>

            <div class="mb-3">
                <label for="foto" class="form-label">Escolha sua foto de perfil</label>
                <input class="form-control form-control-sm col-md-4" id="formFileSm" type="file" name="foto">
            </div>

            <br>
            <h4>Contatos</h4>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Email</label><input type="email" name="email" placeholder="example@mail.com" maxlength="50" class="form-control" required>
                </div>
                <div class="form-group col-md-2">
                    <label>Telefone </label><input type="tel" name="telefone" placeholder="() - " maxlength="14" class="form-control" id="telefone" required>
                </div>
            </div>
            <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-success"><br>
        </form>
    </main>

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
?>


    <script>
        $("#documento").mask("999.999.999-99");
        if (($("#telefone").length) === 11) {
            $("#telefone").mask("(99)99999-9999");
        } else if ((telefone.length) === 10) {
            $("#telefone").mask("(99) 9999-9999");
        }
    </script>
</body>

</html>