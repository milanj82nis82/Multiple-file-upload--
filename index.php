<?php  require_once 'classes/upload.class.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple File Upload</title>
</head>
<body>
    <h2>Upload Multiple Files</h2>
<?php
try {

if (isset($_POST['upload'])) {
    $upload = new Upload('uploads/');
    $uploadStatus = $upload->uploadFiles($_FILES['files']);
    foreach ($uploadStatus as $name => $status) {
        echo $name . ' - ' . $status . '<br>';
    }// foreach


}

} catch ( PDOException $e) {
    echo $e->getMessage();
}

?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="files[]" multiple>
        <input type="submit" name="upload" value="Upload">
    </form>
</body>
</html>