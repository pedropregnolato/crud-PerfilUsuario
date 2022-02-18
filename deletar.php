<?php
session_start();
include_once './conexao.php';

//delete
if (isset($_POST['deletar'])) {
    $id = $_POST['deletar_id'];

    $query = "DELETE FROM cadastro WHERE id='$id'";
    $executar = mysqli_query($conn, $query);

    if ($executar) {
        $_SESSION['success'] = "Cadastro deletado!";
        header('Location: index.php');
    } else {
        $_SESSION['status'] = "Ocorreu um erro. Tente novamente!";
        header('Location: index.php');
    }
}