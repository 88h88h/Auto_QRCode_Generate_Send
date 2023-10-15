<?php
include 'db_config.php';

// Handle button clicks
if (isset($_POST['generate_qr'])) {
    header("Location: generate_qr.php");
    exit();
}

if (isset($_POST['qr_already_generated'])) {
    header("Location: qr_generated.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>QR Code Generator</title>

    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post">
                    <button type="submit" class="btn btn-success btn-block" name="generate_qr">Generate QR</button>
                    <button type="submit" class="btn btn-success btn-block" name="qr_already_generated">QR Already Generated</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>