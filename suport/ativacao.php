<?php

if(!empty($_GET['hash'])){
    
    $data = array("hash" => $_GET['hash']);
    
    $data_post = json_encode($data);
    $url = "http://xtremesolution01.xtremesolution.com.br/hotelaria.hsd/colaborador/ativacao";
    $mediaType = "application/json";
    $charSet = "UTF-8";
    $headers = array();
    $headers[] = "Accept: " . $mediaType;
    $headers[] = "Accept-Charset: " . $charSet;
    $headers[] = "Accept-Encoding: " . $mediaType;
    $headers[] = "Content-Type: " . $mediaType . ";charset=" . $charSet;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    $json = json_decode($result);  
    
    if($json->codigo == 1){
        echo"<script>location.href = 'ativacao-fail.html';</script>";     
        
    }else{
        if($json->message == "ativado"){
            echo"<script>location.href = 'http://xtremesolution01.xtremesolution.com.br/hotelaria.hsd/view/ativacao-success.html';</script>";     
        }else{
            echo"<script>location.href = 'http://xtremesolution01.xtremesolution.com.br/hotelaria.hsd/view/ativacao-fail.html';</script>";     
        }
    }
    
}

