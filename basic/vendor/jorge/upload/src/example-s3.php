<?php
require_once 'Upload/uploadS3.php';

use Upload\uploadS3;

define('awsAccessKey', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
define('awsSecretKey', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');

if(isset($_FILES['file'])) {

    $handle = new uploadS3($_FILES['file']);
    if($handle->uploaded) {

        $handle->bucket               = 'XXXXXXXXX';                            // bucket s3
        $handle->bucket_uri           = 'XXXXXXXXX';                            // diretorio dentro do bucket
        $handle->file_new_name_body   = 'test_'.time();                         // nome arquivo
        $handle->file_safe_name       = true;                                   // formata nome
        $handle->file_overwrite       = true;                                   // sobreescreve
        $handle->allowed              = array('image/*');                       // arquivos permitidos
        $handle->image_convert        = 'jpg';                                  // converte para jpg
        $handle->jpeg_quality         = 72;                                     // qualidade
        $handle->image_resize         = true;                                   // redimensionar
        $handle->image_x              = 100;                                    // largura
        $handle->image_y              = 100;                                    // altura
        $handle->image_ratio_crop     = true;                                   // centralizar e recortar

        $handle->process('/tmp/');                                              // add diretorio temporario

        echo '<pre>';
        if ($handle->processed) {
            $handle->clean();
            print_r('Imagem enviada com sucesso<br>');
            print_r('<img src="http://xxxxxxx.s3-website-sa-east-1.amazonaws.com/img/'.$handle->file_dst_name.'">');
            echo '<hr>';
        } else {
            print_r($handle->error);
            echo '<hr>';
        }
        print_r($handle);
        echo '</pre>';

    } else {
        echo '<pre>';
        print_r('Imagem nao enviada<br>');
        print_r($handle->error);
        echo '<hr>';
        print_r($_FILES['file']);
        echo '<hr>';
        print_r($handle);
        echo '</pre>';
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Upload Files to S3</title>
    </head>
    <body>
        <form method='post' enctype="multipart/form-data">
            <input type='file' name='file'/> <br /><br />
            <input type='submit' value='Upload Image'/>
        </form>
    </body>
</html>