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
    <title>Criação de Perfil</title>
</head>

<body>

    <?php
    if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
        echo $_SESSION['success'];
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
        echo $_SESSION['status'];
        unset($_SESSION['status']);
    }
    ?>

<button><a href="cadastrar.php">Cadastrar</a></button>

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <input type="text" name="nome-pesquisar" placeholder="Quem está procurando?">
        <input type="submit" name="pesquisar" value="Pesquisar">
    </form>

    <br><br>

    <?php
    $pesquisar = filter_input(INPUT_GET, "nome-pesquisar");
    $query = "SELECT * FROM cadastro WHERE nome like '%$pesquisar%' order by id";

    if (isset($pesquisar) && !empty($pesquisar)) {
        $executa_query = mysqli_query($conn, $query);
        if (mysqli_num_rows($executa_query) > 0) {
    ?>
            <table border="1cm">
                <tr>
                    <td>Foto</td>
                    <td>Nome</td>
                    <td>Documento</td>
                    <td>Telefone</td>
                    <td>Editar</td>
                    <td>Apagar</td>
                </tr>

                <?php
                while ($linha = mysqli_fetch_assoc($executa_query)) {
                ?>

                    <tr>
                        <td><?php echo '<img src="fotos/' . $linha['id'] . '/' . $linha['foto'] . '" width="100px" height="100px" alt="Foto">' ?></td>
                        <td>
                            <?php echo ucwords(strtolower($linha['nome'])); ?>
                        </td>
                        <td>
                            <?php echo $linha['documento']; ?>
                        </td>
                        <td>
                            <?php echo $linha['telefone']; ?>
                        </td>
                        <td>
                            <?php echo $linha['email']; ?>
                        </td>
                        <td>
                            <form action="editar.php" method="POST">
                                <input type="hidden" name="editar_id" value="<?php echo $linha['id'] ?>">
                                <input type="submit" name="editar" value="Editar">
                            </form>
                        </td>
                        <td>
                            <form action="deletar.php" method="POST">
                                <input type="hidden" name="deletar_id" value="<?php echo $linha['id'] ?>">
                                <input type="submit" name="deletar" value="Deletar">
                            </form>
                        </td>
                    </tr>

                <?php
                }
                ?>
            </table>
    <?php
        } else {
            echo "Nenhum arquivo encontrado! Tente novamente.";
        }
    } else {
        echo "";
    }
    ?>

</body>

</html>