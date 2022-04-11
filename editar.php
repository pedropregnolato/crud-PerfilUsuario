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

    <title>Alteração de cadastro</title>
</head>

<body>
    <header style="margin-bottom: 3em">
        <nav class="navbar navbar-dark bg-dark d-flex justify-content-between">
            <a class="navbar-brand p-2 flex-grow-1 p-2 bd-highlight" href="#">Cadastrando Perfil</a>
            <a href="cadastrar.php" class="btn btn-outline-success my-2 my-sm-0 p-2 bd-highlight">Novo Cadastro</a>
            <a href="index.php" class="btn btn-outline-danger p-2 bd-highlight">voltar</a>
        </nav>
    </header>
    <main align="left" style="margin-left: 3em">

        <?php
        if (isset($_POST['editar'])) {
            $id = $_POST['editar_id'];

            $query = "SELECT * FROM cadastro WHERE id='$id'";
            $executar_id = mysqli_query($conn, $query);

            foreach ($executar_id as $linha) {
        ?>

                <form action="alterar.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="editar_id" value="<?php echo $linha['id'] ?>">
                    <h4>Informações</h4>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Nome</label><input type="text" name="editar_nome" value="<?php echo ucwords(strtolower($linha['nome'])) ?>" placeholder="Digite o Nome" maxlength="50" class="form-control" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Documento</label><input type="tel" name="editar_documento" placeholder=" .  .  -" maxlength="14" class="form-control" value="<?php echo $linha['documento'] ?>" required>
                        </div>
                    </div>
                    <br>

                    <div class="mb-3">
                        <label class="form-label">Escolha sua foto de perfil</label>
                        <input class="form-control form-control-sm col-md-4" type="file" name="foto" value="<?php echo $linha['foto'] ?>" required>
                    </div>

                    <br>
                    <h4>Contatos</h4>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Email</label><input type="email" name="editar_email" placeholder="example@mail.com" maxlength="50" class="form-control" value="<?php echo $linha['email'] ?>" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Telefone </label><input type="tel" name="editar_telefone" placeholder="() - " maxlength="14" class="form-control" value="<?php echo $linha['telefone'] ?>" required>
                        </div>
                    </div>
                    <input type="submit" name="cadastrar" value="Atualizar" class="btn btn-success"><br>
                </form>
        <?php
            }
        }
        ?>
    </main>
</body>

</html>