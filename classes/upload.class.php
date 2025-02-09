<?php


class Upload {

    private $targetDir;
    private $allowedTypes;
    private $maxSize;

    public function __construct($targetDir, $allowedTypes = ['jpg', 'png', 'gif', 'jpeg'], $maxSize = 5000000) {
        $this->targetDir = $targetDir;
        $this->allowedTypes = $allowedTypes;
        $this->maxSize = $maxSize;
    }

    public function uploadFiles($files) {
        $uploadStatus = [];
        foreach ($files['name'] as $key => $name) {
            $fileTmpName = $files['tmp_name'][$key];
            $fileSize = $files['size'][$key];
            $fileError = $files['error'][$key];
            $fileType = pathinfo($name, PATHINFO_EXTENSION);
            if (!is_dir($this->targetDir)) {
                mkdir($this->targetDir, 0777, true);
            }

            if ($fileError === UPLOAD_ERR_OK) {
                if (in_array($fileType, $this->allowedTypes)) {
                    if ($fileSize <= $this->maxSize) {
                        $targetFilePath = $this->targetDir . basename($name);
                        if (move_uploaded_file($fileTmpName, $targetFilePath)) {
                            $uploadStatus[$name] = "Upload successful.";
                        } else {
                            $uploadStatus[$name] = "Failed to move uploaded file.";
                        }
                    } else {
                        $uploadStatus[$name] = "File size exceeds the maximum limit.";
                    }
                } else {
                    $uploadStatus[$name] = "File type not allowed.";
                }
            } else {
                $uploadStatus[$name] = "Error uploading file.";
            }
        }
        return $uploadStatus;
    }
    
}