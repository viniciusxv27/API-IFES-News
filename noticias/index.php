<?php
    include_once('../conecta.php');
    $dadosEnviados = file_get_contents('php://input');
    $dadosEnviados = json_decode($dadosEnviados, true);
    
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Content-Type: application/json');

    $cxPdo = $conexao;

    $cmdSql = "SELECT * FROM noticias";

    if(isset($dadosEnviados['busca'])){
        $busca = $dadosEnviados['busca'];
        $cmdSql = "SELECT * FROM noticias WHERE noticias.nome LIKE '%$busca%'";
    }

    $cxPrepare = $cxPdo->prepare($cmdSql);
    $dados = [
        'result'=>false,
        'valores' => []
    ];

    if($cxPrepare->execute()){
        if($cxPrepare->rowCount() > 0){
            $dados['result'] = true;
            $dados['valores'] = $cxPrepare->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    echo json_encode($dados['valores'], JSON_NUMERIC_CHECK);
?>