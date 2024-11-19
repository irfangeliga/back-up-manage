<?php
require_once 'vendor/autoload.php';

set_time_limit(0);
session_start();
$success = isset($_SESSION['success']) ? $_SESSION['success'] : 0;

if (isset($_POST['export'])) {
  $output = NULL;
  $result = NULL;
  $database = $_POST['database'];
  $user = $_POST['username'];
  $pass = $_POST['password'];
  $host = $_POST['host'];
  $filename = !empty($_POST['filename']) ? $_POST['filename'] : 'mySQLDump' . rand(10, 1000);

  foreach ($database as $db) {
    $dump = new \Druidfi\Mysqldump\Mysqldump('mysql:host=' . $host . ';dbname=' . $db, $user, $pass);
    $dump->start("./temp/" . $db . '.sql');
  }

  $zip = new ZipArchive();
  $DelFilePath = "./" . $filename . "(" . date('Y-m-d H:i:s') . ").zip";

  if (file_exists($DelFilePath)) {

    unlink($DelFilePath);
  }
  // if ($zip->open($DelFilePath, ZIPARCHIVE::CREATE) != TRUE) {
  if ($zip->open($DelFilePath, ZipArchive::OVERWRITE) != TRUE) {
    die("Could not open archive");
  }

  foreach ($database as $db) {
    $zip->addFile("./temp/" . $db . ".sql", $db . ".sql");
  }

  $zip->close();
  $result = 1;

  if ($result) {
    $_SESSION['success'] = 1;
  } else {
    $_SESSION['success'] = 2;
  }

  foreach ($database as $db) {
    unlink("./temp/" . $db . ".sql");
  }


  header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
  header("Content-Type: application/zip");
  header("Content-Transfer-Encoding: Binary");
  header("Content-Length: " . filesize($DelFilePath));
  header("Content-Disposition: attachment; filename=" . $DelFilePath);
  readfile($DelFilePath);

  unlink($DelFilePath);
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Export SQL Database</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body>
  <div class=" row justify-content-center my-5 mx-0 px-0">
    <div class="col-md-3 border rounded p-3">
      <form id="myForm" class="text-wrap" method="POST" action="" target="_blank">
        <center class="py-3 d-flex justify-content-center">
          <h3 class="border-bottom pb-2 border-primary">Export Your Database</h3>
        </center>
        <div class="mb-3">
          <label for="host" class="form-label fw-bold">Host</label>
          <input type="text" class="form-control" id="host" name="host" required>
        </div>
        <div class="mb-3">
          <label for="username" class="form-label fw-bold">Username</label>
          <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label fw-bold">Password</label>
          <input type="text" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3 text-wrap">
          <label for="database" class="form-label fw-bold">Database Name</label>
          <!-- <input type="text" class="form-control" id="database" name="database" required> -->
          <select id="database" onchange="selectedDatabase(this)" class="form-select">
            <option value="" disabled selected>Pilih Database</option>
          </select>
          <div class="d-flex flex-wrap" id="selectedDtabase"></div>
        </div>
        <div class="mb-3">
          <label for="filename" class="form-label fw-bold">File Name</label>
          <input type="text" class="form-control" id="filename" name="filename">
        </div>
        <div class="mb-3">
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-success" onclick="location.reload()">
              Clear
            </button>
            <input type="submit" value="Export" name="export" class="btn btn-primary" onclick="return myConfirm()">
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php
  $_SESSION['success'] = 0;
  if ($success > 0) {
  ?>
    <a href="./export_sql.php">
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5 text-dark" id="exampleModalLabel">Modal title</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="text-center">
                <?php if ($success == 1) { ?>
                  <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor"
                    class="bi bi-check-circle-fill text-success" viewBox="0 0 16 16">
                    <path
                      d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                  </svg><br><br>
                  <h4 class="text-muted">Export Database Successfully</h4>
                <?php } else { ?>
                  <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor"
                    class="bi bi-x-circle text-success" viewBox="0 0 16 16">
                    <path
                      d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                  </svg><br><br>
                  <h4 class="text-muted">Export Database Failed</h4>
                <?php } ?>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary w-100">OK</button>
            </div>
          </div>
        </div>
      </div>
    </a>
  <?php } ?>

  <script>
    function myConfirm() {
      if (confirm("Are You Sure?") == true) {
        setTimeout(() => {
          location.reload();
        }, 5000);
      } else {
        console.log("You canceled!");
      }
    }

    $(window).on('load', function() {
      $('#exampleModal').modal('show');
    });

    var i = 0;
    $('#password').focusout(function(e) {
      i = 1;
      $('#myForm').submit();
    });

    $("#myForm").submit(function(event) {
      if (i) {
        let formData = $('#myForm').serialize();
        event.preventDefault();
        $.ajax({
          method: "POST",
          url: 'back_end.php',
          data: formData,
          success: function(data) {
            i = 0;
            console.log(data);
            document.getElementById('database').innerHTML = data;
          }
        });
      }
    });

    function selectedDatabase(node) {
      let selected = node.options[node.selectedIndex].text;
      const divText = document.getElementById('selectedDtabase');
      selected = divText.innerHTML +
        `<div style='font-size:12px' class=' px-2 py-1 my-2 mx-1 bg-primary rounded text-white' id='` + selected +
        `'><input type='hidden' value='` + selected + `' name='database[]' />` +
        selected +
        ` <button onclick='document.getElementById("` + selected +
        `").classList.add("d-none")' style='font-size:12px' type='button'
                class='badge bg-transparent py-0 border border-0 text-white'>x</button></div>`;
      divText.innerHTML = selected;
    }
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
  </script>
</body>

</html>