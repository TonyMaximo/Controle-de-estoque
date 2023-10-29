<?php 
$serverNome = "localhost";
$userNome = "root";
$senha = "881249506";
$bancoNome = "controleestoque";

$connect = mysqli_connect($serverNome, $userNome, $senha, $bancoNome);

if (mysqli_connect_error()) {
    echo "Conexão não estabelecida";
} else {
    
}

?>