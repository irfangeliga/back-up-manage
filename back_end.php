<?php
if (isset($_POST['username'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $host = $_POST['host'];
    $conn = mysqli_connect($host, $user, $pass);
    $db = mysqli_query($conn, "SHOW DATABASES");
    $data = [];

    if ($db->num_rows > 0) {
        while ($row = mysqli_fetch_array($db)) {
            $data[] = $row;
        }
        echo "<option disabled selected>Pilih Database</option>";
        foreach ($data as $key => $value) {
            echo ("<option value='" . $value[0] . "'>" . $value[0] . "</option>");
        }
    } else {
        echo "<option disabled selected>Tidak Ada Database</option>";
    }
}
?>