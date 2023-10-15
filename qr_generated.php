<?php
include 'db_config.php';

// Retrieve entries with qr_generated set to 'yes'
$selectSql = "SELECT email, name_address, mobile, state FROM voter_list WHERE qr_generated = 'yes'";
$result = $conn->query($selectSql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>QR Codes Already Generated</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>QR Codes Already Generated</h1>
        <form method="post" action="send_email.php">
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

            <button type="submit" class="btn btn-success" name="send_emails">Send Emails</button>
        </form>
    </div>

    <!-- Add Bootstrap JS and jQuery scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>