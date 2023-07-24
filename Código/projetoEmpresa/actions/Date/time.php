<?php
//Forma procedural 
date_default_timezone_set("America/Sao_Paulo");
echo date("Y-m-d H:i:s");

//echo date(format:"d/m/y");

/* $now = date("Y-m-d H:i:s");
$otherDate = strtotime("2022-11-29 08:20:30");
echo $now; */


/* echo date("Y-m-d H:i:s", $now); */
/* if($now > $otherDate){
    echo "A data ".date("d/m/y"). " é maior!";
}else{
    echo "A data atual é menor";
} */


$now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
$otherDate = new DateTime("2020-11-07 17:00:00", new DateTimeZone("America/Sao_Paulo"));

//Format

$dataBr = $now->format("d/m/Y");
$timeBr = $now->format("H:i");
/* $dataBr = $now->format("d/m/Y H:i"); */
/* echo "Fulano falou as ". $timeBr. " do dia". $dataBr; */

//Modify

$dateModify = $now->modify("+3 days")->format("d/m/Y");
/* 
echo $dateModify; */

//Ad and Sub

$dateAdd= $now->add(new DateInterval("P10Y"))->format("d/m/Y");
echo $dateAdd;