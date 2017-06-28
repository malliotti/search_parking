<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include "recursos/conecao.php";

	$nome_estacionamento = $_POST['estacionamento'];
	$cep = $_POST['postal_code'];
	$logradouro = $_POST['route'];
	$numero = $_POST['street_number'];
	$complemento = $_POST['complemento'];
	$bairro = $_POST['sublocality_level_1'];
	$localidade = $_POST['locality'];
	$uf = $_POST['administrative_area_level_1'];
	$estacionamento_coberto = $_POST['estacionamento_coberto'];
	$horario_atendimento = $_POST['horario_atendimento'];
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];



try {

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO tbl_estacionamento (nome_estacionamento, cep, logradouro, numero,complemento,bairro,localidade,uf,estacionamento_coberto,horario_atendimento,latitude,longitude) VALUES (:1,:2,:3,:4,:5,:6,:7,:8,:9,:10,:11,:12)");
    $stmt->bindParam(':1', $nome_estacionamento);
    $stmt->bindParam(':2', $cep);
    $stmt->bindParam(':3', $logradouro);
    $stmt->bindParam(':4', $numero);
    $stmt->bindParam(':5', $complemento);
    $stmt->bindParam(':6', $bairro);
    $stmt->bindParam(':7', $localidade);
    $stmt->bindParam(':8', $uf);
    $stmt->bindParam(':9', $estacionamento_coberto);
    $stmt->bindParam(':10', $horario_atendimento);
    $stmt->bindParam(':11', $latitude);
    $stmt->bindParam(':12', $longitude);
    $stmt->execute();


    echo"<script>alert('Estacionamento cadastrado');window.location=\"/tcc/sistema/\";</script>";
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
$conn = null;
 ?>