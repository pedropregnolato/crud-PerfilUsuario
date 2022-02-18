<?php
session_start();
include_once './conexao.php';

//update
if (isset($_POST['editar_perfil'])) {
    $editar_id = $_POST['editar_id'];
    $editar_nome = $_POST['editar_nome'];
    $editar_foto = $_FILES['foto']['name'];

    $editar_nome = strtoupper($editar_nome);

    if (file_exists("fotos/" . $editar_id . '/' . $_FILES["foto"]["name"])) {
        $valida_foto = $_FILES['foto']['name'];
        $_SESSION['status'] = "Foto já existente '.$valida_foto.'";
        header('Location: index.php');
    } else {
        $query = "UPDATE cadastro SET nome='$editar_nome', foto='$editar_foto' WHERE id='$editar_id'";
        $executar = mysqli_query($conn, $query);

        if ($executar) {
            move_uploaded_file($_FILES['foto']['tmp_name'], 'fotos/' . $editar_id . '/' . $_FILES['foto']['name']);
            $_SESSION['success'] = "Cadastro atualizado!";
            header('Location: index.php');
        } else {
            $_SESSION['status'] = "Ocorreu um erro. Cadastro não atualizado!";
            header('Location: index.php');
        }
    }
}