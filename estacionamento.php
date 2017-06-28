<?php

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true"); 
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS'); 
header('Access-Control-Max-Age: 1000'); 
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$conexao = new PDO("mysql:host=ip_ou_hostname;dbname=nome_banc0", "nome_usuario","senha");
$sql = "SELECT id_estacionamento, nome_estacionamento, numero_vagas, latitude, longitude FROM tbl_estacionamento";
$result = $conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);
$return = [];
foreach ($result as $row) {
    $return[] = [ 
        'id' => $row['id_estacionamento'],
        'estacionamento' => $row['nome_estacionamento'],
        'numero_vagas' => $row['numero_vagas'],
        'latitude' => $row['latitude'],
        'longitude' => $row['longitude']
    ];
}
$conexao = null;

header('Content-type: application/json');
echo json_encode($return);

?>