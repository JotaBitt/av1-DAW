<?php
    $nome = "";
    $id = "";
    $valor = "";
    $qtde = "";
    $msg = "";

    $arqCarrinho = fopen("carrinho.txt", "r") or die("ERRO ao ler arquivo");
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
        <form action="buscar.php" method="POST">
            <br>
            Coloque o id do produto que deseja buscar: <input type="text" name="id">
            <br>
            <input type="submit" value="Buscar">
        </form>
        <?php echo $msg?>
        <h1>Lista de produtos</h1>
        <table>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Valor</th>
            </tr>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $busca = $_POST['id'];
            $msg = "produto NAO encontrado";
    
            while (!feof($arqCarrinho)) {
                $linhas[] = fgets($arqCarrinho);
                $colunaDados = explode(";", $linhas[$i]);
    
                if ($busca == $colunaDados[0]) {
                    $id = $busca;
                    $nome = $colunaDados[1];
                    $valor = $colunaDados[2];
                    $qtde = $colunaDados[3];
    
                    echo "<tr>". "<td>". $id ."</td>";
                    echo "<td>". $nome ."</td>";
                    echo "<td>". $qtde ."</td>";
                    echo "<td>". $valor ."</td>";
                    echo "</tr>";
                    
                    $msg = "Produto encontrado!";
                    break;
                }
                $i++;
            }
            fclose($arqCarrinho);
        }
        ?>
        </table>
        <?php echo $msg?>
        <br><br>
        <a href="index.php"><button>Voltar ao menu</button></a>
        <a href="alterar.php"><button>Alterar produto</button></a>
        <a href="carrinho.php"><button>Ver carrinho</button></a>
    </body>
</html>