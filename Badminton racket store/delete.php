<?php
require_once 'data.php';

// Check if ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Use prepared statements to prevent SQL Injection
    $stmt = $conn->prepare("DELETE FROM rackets WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to admin dashboard with success status
        header("Location: admin.php?status=deleted");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    
    $stmt->close();
} else {
    header("Location: admin.php");
    exit();
}

$conn->close();
?>