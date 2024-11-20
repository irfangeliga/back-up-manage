<?php
session_start();
if (isset($_SESSION['database'])) {
  $zip = new \ZipArchive();
  $DelFilePath =  $_SESSION['database'];

  if (file_exists($DelFilePath)) {

    unlink($DelFilePath);
  }
  if ($zip->open($DelFilePath, ZIPARCHIVE::CREATE) != TRUE) {
    die("Could not open archive");
  }
  foreach ($_SESSION['database'] as $db) {
    $zip->addFile("./temp/" . $db . ".sql", $db . ".sql");
  }
  // $zip->close();
  exit;

  header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
  header("Content-Type: application/zip");
  header("Content-Transfer-Encoding: Binary");
  header("Content-Length: " . filesize($DelFilePath));
  header("Content-Disposition: attachment; filename=" . $DelFilePath);
  readfile($DelFilePath);

  // unlink($DelFilePath);
  exit;
}
