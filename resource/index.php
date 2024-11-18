<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Resource Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body>
    <div class=" row justify-content-center my-5 mx-0 px-0">
        <div class="col-md-3 border rounded p-3">
            <form id="myForm" class="text-wrap" method="POST" action="back_up.php">
                <center class="py-3 d-flex justify-content-center">
                    <h3 class="border-bottom pb-2 border-primary">Export Resource</h3>
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
                    <label for="path" class="form-label fw-bold">Path</label>
                    <input type="text" class="form-control" id="path" name="path">
                </div>
                <div class="mb-3">
                    <label for="ignore" class="form-label fw-bold">Ignore</label>
                    <input type="text" class="form-control" id="ignore" name="ignore">
                </div>
                <div class="mb-3">
                    <label for="filename" class="form-label fw-bold">Filename</label>
                    <input type="text" class="form-control" id="filename" name="filename">
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-success" onclick="location.reload()">
                            Clear
                        </button>
                        <input type="submit" class="btn btn-primary" name="submit">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>
</body>

</html>