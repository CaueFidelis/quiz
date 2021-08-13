<?php

session_start();
$_SESSION['logado'] = false;
session_unset(); // desregistrar
session_destroy(); // destruir

header('location:login.php?s');

?>