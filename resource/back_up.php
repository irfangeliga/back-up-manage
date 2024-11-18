<?php
set_time_limit(0);
if (isset($_POST['submit'])) {
    $filename = $_POST['filename'] ?? "Resource" . rand(100, 10000);
    $host = $_POST['host'];
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $path = ($_POST['path']) ? $_POST['path'] : ".";
    $ignore = $_POST['ignore'];

    if (empty($host) && empty($user) && empty($pass)) {
        echo "<script>alert('Please fill in the required fields');location.href='index.php'</script>";
        exit;
    }
    if ($ignore) {
        $ignore = explode(",", $ignore);
    }

    $DelFilePath = $filename . ".zip";
    $files = $folder = $skipFol = [];
    $reloadFolder = 0;
    $ftp = ftp_connect($host);
    $login_result = ftp_login($ftp, $user, $pass);
    $zip = new ZipArchive();


    if (file_exists($DelFilePath)) {
        unlink($DelFilePath);
    }

    if ($zip->open($DelFilePath, ZIPARCHIVE::CREATE) != TRUE) {
        die("Could not open archive");
    }


    function getListFile($dir)
    {
        global $files, $folder, $zip, $ftp, $login_result, $ignore, $host, $user, $pass, $reloadFolder;

        $check = 1;
        $tempFiles = [];
        $parentDir = "";
        $parentDir = $dir;
        $dir = "";
        echo $parentDir . " ==AA<br>";
        if ($reloadFolder == 10) {
            $reloadFolder = 0;
            $ftp = ftp_connect($host);
            $login_result = ftp_login($ftp, $user, $pass);
        }

        $ftpDir = ftp_nlist($ftp, $parentDir);
        var_dump($ftpDir);
        echo "===BB===<br><br>";
        foreach ($ftpDir as $key => $ftpValue) {
            if ($key < 2)
                continue;

            if (is_int(strpos($ftpValue, "."))) {
                if (is_int(strpos($ftpValue, ".com")))
                    continue;
                if (in_array("." . (explode(".", $ftpValue)[1]), $ignore))
                    continue;
                $tempFiles[] = $ftpValue;
            } else {
                if (in_array($ftpValue, $ignore))
                    continue;
                $folder[] = $ftpValue;
                $tempDir = "./temp/" . $ftpValue . "/";
                if (!is_dir($tempDir)) {
                    mkdir($tempDir);
                }
                $check = 0;
            }
        }

        $reloadFolder++;
        $reload = 0;
        if ($tempFiles) {
            foreach ($tempFiles as $key3 => $value) {
                if ($reload == 20) {
                    $reload = 0;
                    $ftp = ftp_connect($host);
                    $login_result = ftp_login($ftp, $user, $pass);
                }

                $tempDir = "./temp/" . $parentDir . "/";
                if (!is_dir($tempDir)) {
                    mkdir($tempDir);
                }
                ftp_get($ftp, "./temp/" . $value, $value, FTP_BINARY);
                echo "<br>" . $parentDir . "===" . $value . " CC<br>";
                $zip->addFile("./temp/" . $value, $value);
                $reload++;
            }
        }

        if ($folder && $check == 0) {
            foreach ($folder as $key2 => $value) {
                // if ($key2 > 3)
                //     continue;
                if (is_int(strpos($value, ".")))
                    continue;
                unset($folder[$key2]);
                getListFile($value);
            }
        }
    }


    $contents = ftp_nlist($ftp, $path);
    foreach ($contents as $key1 => $content) {
        if ($key1 < 2)
            continue;
        // if ($key1 == 7)
        //     break;
        $file = str_replace("./", "", $content);


        if (is_int(strpos($file, "."))) {
            if (is_int(strpos($file, ".com")))
                continue;
            if (in_array(explode(".", $file)[1], $ignore))
                continue;

            ftp_get($ftp, "./temp/" . $file, $file, FTP_BINARY);
            $zip->addFile("./temp/" . $file, $file);
        } else {
            if (in_array($file, $ignore))
                continue;
            $tempDir = "./temp/" . $file . "/";
            if (!is_dir($tempDir)) {
                mkdir($tempDir);
            }
            getListFile($file);
        }
    }

    $zip->close();
    ftp_close($ftp);

    header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: Binary");
    header("Content-Length: " . filesize($DelFilePath));
    header("Content-Disposition: attachment; filename=" . $DelFilePath);
    readfile($DelFilePath);

    unlink($DelFilePath);
    exit;
}