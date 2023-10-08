<?php
    $nome = "";
    $valor = "";
    $id = "";
    $msg = "";

    $arqProd = fopen("produtos.txt", "r") or die("Erro ao abrir arquivo produto");
    $i=0;
    $linhas[] = fgets($arqProd);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Loja produto</title>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            tr {
                text-align: center;
            }
            table {
                width: 42%;
            }

        </style>
    </head>
    <body>
        <h1>Jota's Store</h1>
        <table>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Valor</th>
            </tr>

        <?php
            while (!feof($arqProd)) {
                $linhas[] = fgets($arqProd);
                $info = explode(";", $linhas[$i]);
                
                $id = $info[0];
                $nome = $info[1];
                $valor = $info[2];
                $i++;
        ?>
        <tr>
            <td><?php echo $id?></td>
            <td><?php echo $nome?></td>
            <td><?php echo $valor?></td>
        </tr>
    <?php
        }
        fclose($arqProd);
    ?>
        </table>
        <form action="index.php" method="POST">
            <br>
            Coloque o id do produto:<input type="text" name="id">
            <br><br>
            Coloque a quantidade do produto:<input type="number" name="quantidade">
            <br><br>
            <input type="submit" value="Adicionar ao carrinho">
        </form>
<?php
    $nome = "";
    $id = "";
    $valor = "";

    $msg = "";

    $arqProd = fopen("produtos.txt", "r") or die("Erro ao abrir arquivo produto");
    $arqCarrinho = fopen("carrinho.txt", "a") or die("Erro ao abrir arquivo carrinho");
    $i=0;
    $linhas[] = fgets($arqProd);

    //Adicionar ao carrinho
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $qtde = $_POST['quantidade'];

        while (!feof($arqProd)) {
            $linhas[] = fgets($arqProd);
            $info = explode(";", $linhas[$i]);
            $msg = "Produto NAO encontrado";

            if ($info[0] == $id) {
                $nome = $info[1];
                $valor = (float)$info[2];
                $qtde = (float)$qtde;
                $total = $valor * $qtde;

                $linha = "id;nome;valor;qtde\n";
                $linha = $id . ";" . $nome . ";" . $total . ";" . $qtde. "\n";
                fwrite($arqCarrinho, $linha);
                $msg = "Produto adicionado ao carrinho!";
                break;
            }
            $i++;
        }
    }
?>
        <br>
        <?php echo $msg?>
        <br>
        <a href="carrinho.php"><button>Ver carrinho</button></a>
        <a href="buscar.php"><button>Buscar Produto</button></a>
    </body>
</html>
