<?php
namespace Upload;

require_once 'S3/S3.php';
require_once 'upload.php';

use Upload\S3\S3;

class uploadS3 extends upload {

    public $bucket              = '';                                           // bucket S3
    public $bucket_uri          = '';                                           // diretorio dentro do bucket
    public $s3;

    public function __construct($file, $lang = 'en_GB') {

        return parent::__construct($file, $lang);
    }

    public function process($temp_dir = null) {

        parent::process($temp_dir);
        $this->sendS3();
    }

    private function sendS3() {

        if ($this->processed) {

            //upload para S3
            $s3 = new S3(awsAccessKey, awsSecretKey);
            if ($s3->putObjectFile($this->file_dst_pathname,
                    $this->bucket,
                    $this->bucket_uri . $this->file_dst_name,
                    S3::ACL_PUBLIC_READ)) {

                $this->s3 = $s3;

            } else {

                $this->s3 = $s3;
                $this->processed = false;
                $this->error = 'Erro S3';
                return $this;
            }

            //apaga temporario
            unlink($this->file_dst_pathname);
        }
    }
}