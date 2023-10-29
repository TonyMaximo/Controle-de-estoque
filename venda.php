<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área de venda</title>
</head>
<body>
    <a href="cadastro-templete.php" target="_self" rel="prev">Voltar ao inicio</a>
    <a style="margin-left: 10px;" href="historico-venda.php" target="_self" rel="next">historico de vendas</a>
    <h1>Venda de produtos</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <label for="nomeProduto">Nome do produto:</label>
        <input type="text" name="nomeProduto" id="" required>
        <br>
        <label for="quantidade">Está vendendo quantos?:</label>
        <input style="width: 30px;" type="number" name="quantidade" id="" required>
        <br>
        <input type="submit" value="vender" name="enviar">
        <br><br>
    </form>
<?php 
    include("conexao.php"); 

    if (isset($_POST['enviar'])) {
        $nomeProduto = $_POST['nomeProduto'];
        $quantidade = $_POST['quantidade'];

        $sql = "SELECT * FROM estoque WHERE item = '$nomeProduto'";
        $resultado = mysqli_query($connect, $sql);

        if (mysqli_num_rows($resultado) == 1) {
            $row = mysqli_fetch_assoc($resultado);
            $calculo = $row['quantidade'] - $quantidade;

            if ($calculo < 0) {
                ?>
                <p style="color: red;">Não da para vender por que o produto vai ficar com quantidade  abaixo de zero</p>
                <?php
            } else {
                $sql = "UPDATE estoque SET quantidade = '$calculo' WHERE item = '$nomeProduto'";
                $resultado = mysqli_query($connect, $sql);
    
                date_default_timezone_set('America/Bahia');
                $data = date("m/Y");
                
                $sql = "INSERT INTO venda(data, produto, quantidade) VALUES('$data','$nomeProduto', $quantidade)";
                $resultado = mysqli_query($connect, $sql);
            }
        }
    }
?>  

<div class="amostra_produto">
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" autocomplete="off">
        <label for="procurar">Pesquisar produto:</label>
        <br>
        <input type="search" name="procurar" id="" required>
        <button type="submit" name="botaoProcurar">Procurar</button>
    </form>
    <h1>Área dos produtos</h1>
<?php 
    include("conexao.php");
    if (isset($_POST['botaoProcurar'])) {
        $procurar = $_POST['procurar'];
        $array = [];
        $contArray = 0;
        $sql = "SELECT * FROM estoque WHERE item LIKE '$procurar%'";
        $resultado = mysqli_query($connect, $sql);
        
        if (mysqli_num_rows($resultado) >= 1) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $contPro = 0;
                $dividir = str_split($row['item']);
                foreach ($dividir as $key => $value) {
                    if ($contPro < strlen($procurar)) {
                        $juncao[$contPro] = "<strong>$value</strong>";
                    } else {
                        $juncao[$contPro] = $value; 
                    }
                    $contPro++;
                    $juncaoTot = implode($juncao);
                }
                echo "<fieldset>"."data: ".$row["data"]." / produto: ".$juncaoTot." / quantidade: ".$row["quantidade"]."</fieldset>";
            }
        } else {
            echo "<fieldset>Não achei este produto!</fieldset>";
        }

    } else {
        $sql = "SELECT * FROM estoque";
        $resultado = mysqli_query($connect, $sql);
        
        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "<fieldset>"."data: ".$row["data"]." / produto: ".$row["item"]." / quantidade: ".$row["quantidade"]."</fieldset>";

        }
    }
?>
</div>
  
</body>
</html>
