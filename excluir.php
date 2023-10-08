<?php
    $nome = "";
    $id = "";
    $valor = "";

    $msg = "";

    $arqCarrinho = fopen("carrinho.txt", "r") or die("ERRO ao ler arquivo");
    $arqTemp = fopen("temp.txt", "a") or die("ERRO ao escrever no arquivo");
    $i=0;
    $linhas[] = fgets($arqCarrinho);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pesquisa = $_POST['id'];

        while (!feof($arqCarrinho)) {
            $linhas[] = fgets($arqCarrinho);
            $info = explode(";", $linhas[$i]);
            
            if ($info[0] == $pesquisa) {
                $msg = "Produto excluído!";

            } else {
                $id = $info[0];
                $nome = $info[1];
                $total = $info[2];
                $qtde = $info[3];    

                $linha = $id . ";" . $nome . ";" . $total . ";" . $qtde;
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

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Excluir Produto</title>
    </head>
    <body>
        <br><br>
        <?php echo $msg?>
        <br><br>
        <a href="index.php"><button>Voltar ao menu</button></a>
        <a href="carrinho.php"><button>Ver carrinho</button></a>
    </body>
</html>
