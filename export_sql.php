<?php
set_time_limit(500);
$success = 0;
if (isset($_POST['export'])) {
  // var_dump($_POST);
  // exit;
  $filename = isset($_POST['filename']) ? $_POST['filename'] : 'mySQLDump' . rand(10, 1000);
  $database = $_POST['database'];
  $user     = $_POST['username'];
  $pass     = $_POST['password'];
  $host     = $_POST['host'];
  $dir      = getenv('HOMEDRIVE') . getenv('HOMEPATH') . '\Downloads' . '/' . $filename . '.sql';
  $conn = mysqli_connect($host, $user, $pass);
  $db = mysqli_query($conn, "SHOW DATABASES");
  while ($row = mysqli_fetch_array($db)) {
    echo ($row[0]);
  }
  // exec("mysqldump --user={$user} --password={$pass} --host={$host} {$database} --result-file={$dir} 2>&1", $output);
  // $success = 1;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Export SQL Database</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
  <div class=" row justify-content-center my-5 mx-0 px-0">
    <div class="col-md-3 border rounded p-3">
      <form id="myForm">
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
        <div class="mb-3">
          <label for="database" class="form-label fw-bold">Database Name</label>
          <input type="text" class="form-control" id="database" name="database" required>
        </div>
        <div class="mb-3">
          <label for="filename" class="form-label fw-bold">File Name</label>
          <input type="text" class="form-control" id="filename" name="filename">
        </div>
        <div class="mb-3">
          <input type="submit" value="Export" name="export" class="btn btn-primary float-end" onclick="return confirm('Are you sure?')">
        </div>
      </form>
    </div>
  </div>

  <!-- <div class="modal fade" id="spin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="spinner-border text-primary" role="status">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content  d-flex justify-content-center">
          <span style="left:50%;" class="text-center visually-hidden">Loading...</span>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
  <script>
    function spin() {
      if (confirm("Are you sure?") == true) {
        $('#spin').modal('show');
      }
    }
  </script> -->

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
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-check-circle-fill text-success" viewBox="0 0 16 16">
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
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
      $(window).on('load', function() {
        $('#exampleModal').modal('show');
      });
    </script>
  <?php } ?>
  <script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

  <script>
    $("#myForm").submit(function(event) {
      let formData = $('#myForm').serialize();

      /* Or use serializeArray() function same as serialize()
      let formData = $('#myForm').serializeArray(); */
      $.ajax({
        method: "POST",
        url: 'export_sql.php',
        data: formData,
        success: function(data) {
          var res = JSON.parse(data);
          console.log(res);
        }
      })
    });
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>