<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

set_time_limit(500);
$success = 0;

if (isset($_POST['export'])) {
  $output = NULL;
  $result = NULL;
  $database = "laravel11";
  $user = $_POST['username'];
  $pass = $_POST['password'];
  $host = $_POST['host'];
  $filename = !empty($_POST['filename']) ? $_POST['filename'] : 'mySQLDump' . rand(10, 1000);
  $dir = getenv('HOMEDRIVE') . getenv('HOMEPATH') . '\Downloads' . '/' . $filename . '.sql';

  // $mime = "application/x-gzip";
  // header("Content-Type: " . $mime);
  // header('Content-Disposition: attachment; filename="' . $filename . '"');
  // $cmd = "mysqldump -u $user --password=$pass $database | gzip --best";
  // passthru($cmd);

  // exec('mysqldump --user=' . $user . ' --password=' . $pass . ' --host=' . $host . ' ' . $database[0] . ' > mysqk.sql', $output, $result);
  // var_dump($output, $result);
  // exec("mysqldump --opt --user={$user} --password={$pass} --host={$host} {$database} --result-file={$dir} 2>&1", $output);
  // foreach ($database as $db) {
  // shell_exec("mysqldump --user={$user} --password={$pass} --host={$host} {$db} --result-file={$dir} 2>&1");
  // }
  // exec("mysqldump --user=" . $user . " --password=" . $pass . " --host=" . $host . " " . $database[0] . " --result-file=" . $dir . " 2>&1", $output);
  // $command = 'mysqldump --opt -h ' . $host . ' -u ' . $user . ' -p' . $password . ' ' . $database . ' > ' . $filename;

  // exec($command, $output = array(), $worked);

  // $return_var = NULL;
  // $output = NULL;
  $command = "mysqldump --host=" . $host . " --user=" . $user . " --password=" . $pass . " " . $database . " > " . $filename . ".sql";
  exec($command);
  // var_dump($output, $return_var);
  $success = 1;
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
      <form id="myForm" class="text-wrap" method="POST" action="">
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
            <input type="submit" value="Export" name="export" class="btn btn-primary"
              onclick="return confirm('Are you sure?')">
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php if ($success == 1) { ?>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor"
                  class="bi bi-check-circle-fill text-success" viewBox="0 0 16 16">
                  <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </svg><br><br>
                <h4 class="text-muted">Export Database Successfully</h4>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary w-100">OK</button>
            </div>
          </div>
        </div>
      </div>
    </a>

    <script>
      $(window).on('load', function () {
        $('#exampleModal').modal('show');
      });
    </script>
  <?php } ?>

  <script>
    var i = 0;
    $('#password').focusout(function (e) {
      i = 1;
      $('#myForm').submit();
    });

    $("#myForm").submit(function (event) {
      if (i) {
        let formData = $('#myForm').serialize();
        event.preventDefault();
        $.ajax({
          method: "POST",
          url: 'back_end.php',
          data: formData,
          success: function (data) {
            i = 0;
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
        `'><input type='hidden' value='` + selected + `' name='database[]'/>` +
        selected +
        ` <button onclick='document.getElementById("` + selected +
        `").classList.add("d-none")' style='font-size:12px' type='button' class='badge bg-transparent py-0 border border-0 text-white'>x</button></div>`;
      divText.innerHTML = selected;
    }
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>