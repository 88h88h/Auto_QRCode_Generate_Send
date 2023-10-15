<?php
include 'db_config.php';
// Include the QR Code library
require 'vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Handle form submission to generate QR codes and update the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['generate_qr_codes'])) {
        $selectedEmails = $_POST['selected_emails'];



        // Loop through selected emails to generate and save QR codes
        foreach ($selectedEmails as $email) {
            // Generate a unique filename for each QR code
            $filename = uniqid() . '.png';


            $data = $email;




            $qr = QrCode::create("$data");
            $writer = new PngWriter();
            $result = $writer->write($qr);


            $result->saveToFile(__DIR__ . "/images/$email.png");

            $qr_path = __DIR__ . "/images/$email.png";


            // Update the database to set qr_generated to 'yes' and save the QR code path
            $updateSql = "UPDATE voter_list SET qr_generated = 'yes', qr_path = '$qr_path' WHERE email = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->close();
        }

        // Redirect back to the main page
        header("Location: index.php");
        exit();
    }
}

// Retrieve entries with qr_generated set to 'no'
$selectSql = "SELECT email, name_address, mobile, state FROM voter_list WHERE qr_generated = 'no'";
$result = $conn->query($selectSql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Generate QR Codes</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Generate QR Codes</h1>
        <form method="post">
            <table class="table table-bordered">
                <thead class="bg-success text-white">
                    <tr>
                        <th>Email</th>
                        <th>Name/Address</th>
                        <th>Mobile</th>
                        <th>State</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['name_address'] . "</td>";
                        echo "<td>" . $row['mobile'] . "</td>";
                        echo "<td>" . $row['state'] . "</td>";
                        echo "<td><input type='checkbox' name='selected_emails[]' value='" . $row['email'] . "'></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <button type="submit" class="btn btn-success" name="generate_qr_codes">Generate QR Codes</button>
        </form>
    </div>

    <!-- Add Bootstrap JS and jQuery scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>