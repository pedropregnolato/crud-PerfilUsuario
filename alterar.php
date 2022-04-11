<?php
session_start();
include_once './conexao.php';

//update
if (isset($_POST['editar_perfil'])) {
    $editar_id = $_POST['editar_id'];
    $editar_nome = strtoupper(preg_replace("/[^a-zA-Z ]+/", "", $_POST['editar_nome']));
    $editar_documento = preg_replace("/[^0-9]/", "", $_POST['editar_documento']);
    $editar_telefone = preg_replace("/[^0-9]/", "", $_POST['editar_telefone']);
    $editar_email = $_POST['editar_email'];
    $editar_foto = $_FILES['foto']['name'];

}