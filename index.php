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

    <title>Busca de Perfil</title>
</head>

<body class="d-flex flex-column h-100">
    <header>
        <nav class="navbar navbar-dark bg-dark justify-content-between">
            <a class="navbar-brand" href="#">Buscando Perfil</a>

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-inline">
                <input type="search" class="form-control mr-sm-2" name="nome-pesquisar" placeholder="Quem está procurando?">
                <input type="submit" class="btn btn-outline-primary" name="pesquisar" value="Pesquisar">
            </form>

            <a href="cadastrar.php" class="btn btn-outline-success my-2 my-sm-0">Cadastrar</a>

        </nav>
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
    </header>
    <main class="flex-shrink-0" role="main">
        <?php
        $pesquisar = filter_input(INPUT_GET, "nome-pesquisar");
        $query = "SELECT * FROM cadastro WHERE nome like '%$pesquisar%' order by id";

        if (isset($pesquisar) && !empty($pesquisar)) {
            $executa_query = mysqli_query($conn, $query);
            if (mysqli_num_rows($executa_query) > 0) {
        ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Foto</th>
                            <th scope="col">Nome</td>
                            <th scope="col">Documento</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Apagar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($linha = mysqli_fetch_assoc($executa_query)) {
                        ?>

                            <tr>
                                <td>
                                    <?php
                                        echo '<img src="fotos/' . $linha['id'] . '/' . $linha['foto'] . '" width="80px" height="80px" alt="Foto" style="border-radius: 100%">'
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        echo ucwords(strtolower($linha['nome'])); 
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo preg_replace("/([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})/", "$1.$2.$3-$4", $linha['documento']);
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        if(strlen($linha['telefone']) == 11){
                                            echo preg_replace("/([0-9]{2})([0-9]{5})([0-9]{4})/", "($1)$2-$3", $linha['telefone']);
                                        } else if (strlen($linha['telefone']) == 10){
                                            echo preg_replace("/([0-9]{2})([0-9]{4})([0-9]{4})/", "$1 $2-$3", $linha['telefone']);
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo $linha['email'];
                                    ?>
                                </td>
                                <td>
                                    <form action="editar.php" method="POST">
                                        <input type="hidden" name="editar_id" value="<?php echo $linha['id'] ?>">
                                        <input type="submit" name="editar" value="Editar" class="btn btn-info">
                                    </form>
                                </td>
                                <td>
                                    <form action="deletar.php" method="POST">
                                        <input type="hidden" name="deletar_id" value="<?php echo $linha['id'] ?>">
                                        <input type="submit" name="deletar" value="Apagar" class="btn btn-danger">
                                    </form>
                                </td>
                            </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
        <?php
            } else {
                echo "Nenhum arquivo encontrado! Tente novamente.";
            }
        } else {
            echo "";
        }
        ?>
    </main>
</body>

</html>