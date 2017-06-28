<?php

    $conn = new PDO("mysql:host=ip_ou_hostname;dbname=nome_banco","nome_usuario","senha");

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  ?>