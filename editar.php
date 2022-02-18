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
    <title>Editar</title>
</head>

<body>

    <?php
    if (isset($_POST['editar'])) {
        $id = $_POST['editar_id'];

        $query = "SELECT * FROM cadastro WHERE id='$id'";
        $executar_id = mysqli_query($conn, $query);

        foreach ($executar_id as $linha) {
    ?>
            <form action="alterar.php" method="POST" enctype="multipart/form-data"><br>
                <input type="hidden" name="editar_id" value="<?php echo $linha['id'] ?>">
                nome: <input type="text" name="editar_nome" value="<?php echo ucwords(strtolower($linha['nome'])) ?>" placeholder="Digite o Nome"><br>
                Clique para <input type="file" name="foto" value="<?php echo $linha['foto'] ?>" ><br>
                <input type="submit" name="editar_perfil" value="Atualizar"><br>
            </form>
    <?php
        }
    }
    ?>
<br><br>
    <button><a href="index.php">voltar</a></button>
</body>

</html>