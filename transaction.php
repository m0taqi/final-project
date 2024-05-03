<?php
include("db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {
    $sender_id = $_SESSION["user_id"];
    $receiver_nfc_card = $_POST["receiver_nfc_card"];
    $amount = $_POST["amount"];
    $password = $_POST["password"];

    // Validate password before processing the transaction
    $user_sql = "SELECT * FROM users WHERE id = $sender_id";
    $user_result = $conn->query($user_sql);
    $user = $user_result->fetch_assoc();

    if (password_verify($password, $user["password"])) {
        // Verify the receiver's NFC card and process the transaction
        $receiver_sql = "SELECT id FROM users WHERE nfc_card = '$receiver_nfc_card'";
        $receiver_result = $conn->query($receiver_sql);

        if ($receiver_result->num_rows > 0) {
            $receiver = $receiver_result->fetch_assoc();
            $receiver_id = $receiver["id"];

            // Update balances and record the transaction
            $conn->begin_transaction();

            $update_sender_balance = "UPDATE users SET balance = balance - $amount WHERE id = $sender_id";
            $update_receiver_balance = "UPDATE users SET balance = balance + $amount WHERE id = $receiver_id";

            $insert_transaction = "INSERT INTO transactions (sender_id, receiver_id, amount) VALUES ($sender_id, $receiver_id, $amount)";

            if ($conn->query($update_sender_balance) && $conn->query($update_receiver_balance) && $conn->query($insert_transaction)) {
                $conn->commit();
                echo "Transaction successful.";
            } else {
                $conn->rollback();
                echo "Transaction failed.";
            }
        } else {
            echo "Receiver not found.";
        }
    } else {
        echo "Invalid password.";
    }
}
?>

<html>
<!-- Transaction form -->
</html>
