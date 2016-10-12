<?php
require_once('config.php');
require_once('S3.php');
echo '<pre>';

$s3 = new S3(awsAccessKey, awsSecretKey);

$bucket = "educasao";

//Lista diretorios e arquivos do bucket
//$res = $s3->getBucket($bucket);
//print_r($res);

//Retorna o objeto
$uri = 'avatars/99234134.jpg';
$res = $s3->getObject($bucket, $uri);
print_r($res);

//Retorna apenas informações do objeto
$uri = 'avatars/99234134.jpg';
$res = $s3->getObjectInfo($bucket, $uri);
print_r($res);

?>