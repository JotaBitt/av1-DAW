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
        <title>Carrinho</title>
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
        <h1>Carrinho</h1>
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
        <form action="excluir.php" method="POST">
            <br><br>
            Digite o código do produto: <input type="number" name="id">
            <br><br>
            <input type="submit" value="Excluir produto">
        </form>

    <br>
    <?php echo $msg?>
    <br>
    <a href="index.php"><button>Voltar ao menu</button></a>
    <a href="alterar.php"><button>Alterar Produto</button></a>
    </body>
</html>
