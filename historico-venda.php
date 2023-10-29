<a href="cadastro-templete.php" target="_self" rel="prev">Voltar ao inicio</a>
<a style="margin-left: 10px;" href="venda.php" target="_self" rel="prev">Vender</a>

<br><br>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <label for="procurar">pesquisar por data: </label>
    <input type="text" name="procurar" id="" placeholder="10/2023">
    <input type="submit" value="procurar" name="enviar">
    <hr>
</form>

<?php 
require("conexao.php");

if (isset($_POST['enviar'])) {
    sleep(1);
    $data = $_POST['procurar'];

    $sql = "SELECT * FROM venda WHERE data = '$data'";
    $resultado = mysqli_query($connect, $sql);

    if (mysqli_num_rows($resultado) >= 1) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            ?>
            <p><?=$row['data']?> <?=$row['produto']?> <?=$row['quantidade']?></p>
            <?php
        }
    } else {
        ?>
        <p style="color: red;">Não achei este produto</p>
        <?php
    }
} else {
    $sql = "SELECT * FROM venda";
    $resultado = mysqli_query($connect, $sql);

    if (mysqli_num_rows($resultado) >= 1) {
        ?>
        <h3>Vendas feitas:</h3>
        <?php
        while ($row = mysqli_fetch_assoc($resultado)) {
            ?>
            <p><?=$row['data']?> <?=$row['produto']?> <?=$row['quantidade']?></p>
            <?php 
        }
    } else {
        ?>
        <h3>Não fez nenhuma venda</h3>
        <?php 
    }    
}

?>