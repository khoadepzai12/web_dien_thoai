<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: dangki.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$address_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($address_id > 0) {
    // Check if the address exists before attempting to delete
    $check_stmt = $conn->prepare("SELECT * FROM dia_chi_giao_hang WHERE id = ? AND khach_hang_id = ?");
    $check_stmt->bind_param("ii", $address_id, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows === 1) {
        // The address exists, proceed to delete
        $stmt = $conn->prepare("DELETE FROM dia_chi_giao_hang WHERE id = ? AND khach_hang_id = ?");
        $stmt->bind_param("ii", $address_id, $user_id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            // Address deleted successfully
            header('Location: dia_chi.php');
            exit();
        } else {
            echo "Error: Unable to delete address.";
        }
        $stmt->close();
    } else {
        echo "Address not found or you don't have permission to delete it.";
    }
    $check_stmt->close();
} else {
    // Invalid address ID
    echo "Invalid address ID.";
    exit();
}
?>
