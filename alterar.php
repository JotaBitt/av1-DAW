<?php
    $nome = "";
    $id = "";
    $valor = "";

    $msg = "";

    $arqCarrinho = fopen("carrinho.txt", "r") or die("Erro ao abrir arquivo carrinho");
    $linhas[] = fgets($arqCarrinho);
    $i=0;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Alterar produto</title>
        <style>
             table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            tr {
                text-align: center;
            }
            table {
                width: 48%;
            }
            
        </style>
    </head>
    <body>
        <h1>Lista de produtos</h1>
        <table>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Valor</th>
            </tr>
        <?php
            while (!feof($arqCarrinho)) {
                $linhas[] = fgets($arqCarrinho);
                $info = explode(";", $linhas[$i]);

                $id = $info[0];
                $nome = $info[1];
                $valor = $info[2];
                $qtde = $info[3];
            
        ?>
        <tr>
            <td><?php echo $id?></td>
            <td><?php echo $nome?></td>
            <td><?php echo $qtde?></td>
            <td><?php echo $valor?></td>
        </tr>
        <?php
            $i++;
            }
            fclose($arqCarrinho);
        ?>
        </table>
    <br>
    <?php
        $nome = "";
        $valor = "";
        $qtde = "";
        $id = "";

        $arqCarrinho = fopen("carrinho.txt", "r") or die ("Erro ao ler arquivo produto");
        $arqProduto = fopen("produtos.txt", "r") or die("Erro ao abrir arquivo produto");
        $arqTemp = fopen("temp.txt", "a") or die("Erro ao escrever arquivo temp");
        $i=0;
        $linhas[] = fgets($arqCarrinho);
        $linhasProd[] = fgets($arqProduto);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $busca = $_POST['busca'];
            $msg = "Produto NAO encontrado!";

            while(!feof($arqCarrinho)) {
                $linhasProd[] = fgets($arqProduto);
                $linhas[] = fgets($arqCarrinho);
                $dados = explode(";", $linhas[$i]);
                $info = explode(";", $linhasProd[$i]);

                if ($busca == $dados[0]) {
                    $msg = "Produto alterado!";
                    $id = $dados[0];
                    $nome = $dados[1];
                    $valor = (float)$info[2];
                    $qtde = (float)$_POST['qtde'];

                    $total = $qtde * $valor;
                    $linha = $id . ";" . $nome . ";" . $total . ";" . $qtde . "\n";

                    fwrite($arqTemp, $linha);

                } else {
                    $id = $dados[0];
                    $nome = $dados[1];
                    $valor = $dados[2];
                    $qtde = $dados[3];

                    $linha = $id . ";" . $nome . ";" . $valor . ";" . $qtde;

                    fwrite($arqTemp, $linha);
                }
                $i++;
            }
            copy("temp.txt", "carrinho.txt");
            fclose($arqCarrinho);
            fclose($arqTemp);
            unlink("temp.txt");
        }
    ?>
    <form action="alterar.php" method="POST">
        <br>
        <label for="busca">
            id do produto que deseja alterar: <input type="number" name="busca" id="busca">
        </label>
        <br><br>
            Nova quantidade: <input type="number" id="qtde" name="qtde">
        <br><br>
        <input type="submit" value="Alterar">
        <br><br>
    </form>    
    <?php echo $msg?>
    <br>
        <a href="index.php"><button>Voltar ao menu</button></a>
        <a href="carrinho.php"><button>Ver carrinho</button></a>
    </body>
</html>