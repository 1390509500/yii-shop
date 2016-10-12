<?php
require_once('config.php');

if(isset($_FILES['file'])) {
        
    $bucket            = "educasao";
    $actual_image_name = 'avatars/'.$_FILES['file']['name'];
    $tmp               = $_FILES['file']['tmp_name'];        
            
    require_once('S3.php');
    
    $s3 = new S3(awsAccessKey, awsSecretKey);

    //$s3->putBucket($bucket, S3::ACL_PUBLIC_READ);
    
    if ($s3->putObjectFile($tmp, $bucket, $actual_image_name, S3::ACL_PUBLIC_READ)) {
        
        $msg  = "S3 Upload Successful.<br/>";
        
        $s3file = 'http://s3-sa-east-1.amazonaws.com/educasao/' . $actual_image_name;
        
        $msg .= "<img src='$s3file' style='max-width:400px'/>";
        
    } else {
        
        $msg = "S3 Upload Fail.";    
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Upload Files to Amazon S3 PHP</title>
    </head>
    <body>
        <?php
            echo $msg . '<br/>';
        ?>
        <form action="" method='post' enctype="multipart/form-data">
            <input type='file' name='file'/> <br /><br />
            <input type='submit' value='Upload Image'/>
        </form>        
    </body>    
</html>
