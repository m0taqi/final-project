<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $nfc_card = $_POST["nfc_card"];

    $sql = "INSERT INTO users (username, password, nfc_card) VALUES ('$username', '$password', '$nfc_card')";

    if ($conn->query($sql) === TRUE) {
        header("Location: wellcome.html");

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<html>
<!-- Signup form -->
</html>
