<?php
//Fonte: http://www.mauricioprogramador.com.br/posts/exportando-dados-do-mysql-para-excel-com-php

// Nome do Arquivo do Excel que será gerado
$arquivo = 'lista_estacionamentos.xls';

// Criamos uma tabela HTML com o formato da planilha para excel
$tabela = '<table border="1">';
$tabela .= '<tr>';
$tabela .= '<td colspan="2">Tabela de Estacionamentos</tr>';
$tabela .= '</tr>';
$tabela .= '<tr>';
$tabela .= '<td><b>ID</b></td>';
$tabela .= '<td><b>Estacionamento</b></td>';
$tabela .= '</tr>';

$conexao = new PDO("mysql:host=179.188.17.92;dbname=tecnoweb_tcc", "tecnoweb_user","@12@34@56");
$sql = "SELECT id_estacionamento, nome_estacionamento, latitude, longitude FROM tbl_estacionamento";
$result = $conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $row) {
	$tabela .= '<tr>';
	$tabela .= '<td>'.$row['id_estacionamento'].'</td>';
	$tabela .= '<td>'.$row['nome_estacionamento'].'</td>';
	$tabela .= '</tr>';
}

$tabela .= '</table>';

// Força o Download do Arquivo Gerado
header ('Cache-Control: no-cache, must-revalidate');
header ('Pragma: no-cache');
header('Content-Type: application/x-msexcel');
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"");
echo $tabela;

?>
