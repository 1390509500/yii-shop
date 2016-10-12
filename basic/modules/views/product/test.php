<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daniel.uy - Online Code Demos</title>

    <!-- Bootstrap -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="admin/css/uploader.css" rel="stylesheet" />
    <link rel="stylesheet" href="admin/css/upload.css" rel="stylesheet" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <![endif]-->
</head>



<div class="container demo-wrapper">
    <div class="row demo-columns">
        <div class="col-md-6">
            <!-- D&D Zone-->
            <div id="drag-and-drop-zone" class="uploader">
                <div>Drag &amp; Drop Images Here</div>
                <div class="or">-or-</div>
                <div class="browser">
                    <label>
                        <span>Click to open the file Browser</span>
                        <input type="file" name="files[]" multiple="multiple" title='Click to add Files'>
                    </label>
                </div>
            </div>
            <!-- /D&D Zone -->
        </div>
        <!-- / Left column -->

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Uploads</h3>
                </div>
                <div class="panel-body demo-panel-files" id='demo-files'>
                    <span class="demo-note">No Files have been selected/droped yet...</span>
                </div>
            </div>
        </div>
        <!-- / Right column -->
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script> -->

<script type="text/javascript" src="admin/js/demo.min.js"></script>
<script type="text/javascript" src="admin/js/dmuploader.min.js"></script>

<script type="text/javascript">
    $('#drag-and-drop-zone').dmUploader({
        url: '<?php echo yii\helpers\Url::to(['product/upload'])?>',
        dataType: 'json',
        allowedTypes: 'image/*',
        /*extFilter: 'jpg;png;gif',*/
        onInit: function(){
            $.danidemo.addLog('#demo-debug', 'default', 'Plugin initialized correctly');
        },
        onBeforeUpload: function(id){
            $.danidemo.addLog('#demo-debug', 'default', 'Starting the upload of #' + id);

            $.danidemo.updateFileStatus(id, 'default', 'Uploading...');
        },
        onNewFile: function(id, file){
            $.danidemo.addFile('#demo-files', id, file);
        },
        onComplete: function(){
            $.danidemo.addLog('#demo-debug', 'default', 'All pending tranfers completed');
        },
        onUploadProgress: function(id, percent){
            var percentStr = percent + '%';

            $.danidemo.updateFileProgress(id, percentStr);
        },
        onUploadSuccess: function(id, data){
            $.danidemo.addLog('#demo-debug', 'success', 'Upload of file #' + id + ' completed');

            $.danidemo.addLog('#demo-debug', 'info', 'Server Response for file #' + id + ': ' + JSON.stringify(data));

            $.danidemo.updateFileStatus(id, 'success', 'Upload Complete');

            $.danidemo.updateFileProgress(id, '100%');
        },
        onUploadError: function(id, message){
            $.danidemo.updateFileStatus(id, 'error', message);

            $.danidemo.addLog('#demo-debug', 'error', 'Failed to Upload file #' + id + ': ' + message);
        },
        onFileTypeError: function(file){
            $.danidemo.addLog('#demo-debug', 'error', 'File \'' + file.name + '\' cannot be added: must be an image');
        },
        onFileSizeError: function(file){
            $.danidemo.addLog('#demo-debug', 'error', 'File \'' + file.name + '\' cannot be added: size excess limit');
        },
        /*onFileExtError: function(file){
         $.danidemo.addLog('#demo-debug', 'error', 'File \'' + file.name + '\' has a Not Allowed Extension');
         },*/
        onFallbackMode: function(message){
            $.danidemo.addLog('#demo-debug', 'info', 'Browser not supported(do something else here!): ' + message);
        }
    });
</script>

</body>
</html>
