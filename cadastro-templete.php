<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de estoque</title>
    <style>
        body {
            margin-left: 30px;
        }

        .amostra_produto {
            position: relative;
            width: 30%;
            margin: auto;
            margin-left: 70%;
            bottom: 500px;
        }

        .resposta_banco {
            position: absolute;
        }
    </style>
</head>
<body>
    <!---->
    <a href="venda.php" target="_self" rel="next">Vender</a>
    <a style="margin-left: 10px;" href="historico-venda.php" target="_self" rel="next">historico de vendas</a>
    <h1>Adicionar</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" autocomplete="off">
        <label for="produto">Produto:</label>
        <input type="text" name="produto" required>
        <br><br>
        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" required>
        <br><br>
        <button type="submit" name="botaoCriar">Criar</button>
    </form>     
    <h1>Modificar</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" autocomplete="off">
        <label for="id">Alterar nome:</label>
        <input type="text" name="altProduto">
        <br><br>
        <label for="id">Nome produto:</label>
        <input type="text" name="produto" required>
        <br><br>
        <label for="quantidade">modificar quantidade:</label>
        <input style="width: 80px;" type="number" name="quantidade" required>
        <br><br>
        <button type="submit" name="botaoAdicionar">Modificar</button>
    </form>
    <h1>Excluir</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" autocomplete="off">
        <label for="produto">Nome do produto:</label>
        <input type="text" name="produto" required>
        <br><br>
        <button type="submit" name="botaoExcluir">Excluir</button>
    </form>
</body>
</html>
<div class="resposta_banco">
<?php 
    include("conexao.php");

    if (isset($_POST['botaoCriar'])) {
        $produto = $_POST['produto'];
        $quantidade = $_POST['quantidade'];
        date_default_timezone_set('America/Bahia');
        $data = date("H:i");

        if ($quantidade >= 0) {
            $sql = "SELECT item FROM estoque WHERE item = '$produto'";
            $resultado = mysqli_query($connect, $sql);

            if (mysqli_num_rows($resultado) == 0) {
                $adicionado = "Produto e quantidade adicionada";
                $sql = "INSERT INTO estoque(item, quantidade, data) VALUES('$produto', $quantidade, '$data')";
                $resultado = mysqli_query($connect, $sql);

                ?>
                <p style="color: green;">Adicionado com sucesso!</p>
                
            <?php
            } else {
            ?>
                <p style="color: red;">Este produto já existe!</p>
                
    <?php
            }
        } else { 
            echo "Coloque um valor igual ou acima de 0";
        }
    }
    ?>

<?php 
    if (isset($_POST['botaoAdicionar'])) {
        $altProduto = $_POST['altProduto'];
        $produto = $_POST['produto'];
        $quantidade = $_POST['quantidade'];
        $data = date("m:h");

        if ($quantidade >= 0) {
            $sql = "SELECT item FROM estoque WHERE item = '$produto'";
            $resultado = mysqli_query($connect, $sql);

            if (mysqli_num_rows($resultado) == 1) {
                if (!$_POST['altProduto'] == "") {
                    $sql = "UPDATE estoque SET item = '$altProduto',  quantidade = $quantidade, data = '$data' WHERE item = '$produto'";
                    $resultado = mysqli_query($connect, $sql);

                    ?>
                    <p style="color: green;">Modificado com sucesso!</p>
                <?php
                } else {
                    $sql = "UPDATE estoque SET quantidade = $quantidade, data = '$data' WHERE item = '$produto'";
                    $resultado = mysqli_query($connect, $sql);

                    ?>
                    <p style="color: green;">Modificado com sucesso!</p>

            <?php
                }
            } else {
            ?>
                <p style="color: red;">Não achei este produto!</p>

    <?php
            }
        } else { 
            echo "Coloque um valor igual ou acima de 0";
        }
    } 
    ?>

<?php 
    if (isset($_POST['botaoExcluir'])) {
        $produto = $_POST['produto'];

        $sql = "SELECT item FROM estoque WHERE item = '$produto'";
        $resultado = mysqli_query($connect, $sql);

        if (mysqli_num_rows($resultado) == 1) {
            $sql = "DELETE FROM estoque WHERE item = '$produto'";
            $resultado = mysqli_query($connect, $sql);

            ?>
            <p style="color: green;">Excluido com sucesso!</p>
            
        <?php
        } else {
        ?>
            <p style="color: red;">Não achei este produto!</p>
            
    <?php
        }
    }
    ?>
</div>

<div class="amostra_produto">
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" autocomplete="off">
        <label for="procurar">Pesquisar produto:</label>
        <br>
        <input type="search" name="procurar" id="" required>
        <button type="submit" name="botaoProcurar">Procurar</button>
    </form>
    <h1>Área dos produtos</h1>
<?php 
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
