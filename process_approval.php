<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("db_connect.php");

$request_id = '';
$status = '';
$schedule_date = "";

// 1. HANDLE POST (AJAX Submission)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request_id'])) {
    $request_id = mysqli_real_escape_string($conn, $_POST['request_id']);
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'approve') {
        $schedule_date = mysqli_real_escape_string($conn, $_POST['schedule_date']);
        $status = 'Approved';
    } 
    elseif ($action === 'reject') {
        $status = 'Rejected';
        $schedule_date = ""; 
    }
} 
// 2. HANDLE GET (Backup for direct links)
elseif (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'reject') {
    $request_id = mysqli_real_escape_string($conn, $_GET['id']);
    $status = 'Rejected';
    $schedule_date = ""; 
}

// 3. EXECUTE UPDATE & NOTIFY
if (!empty($status) && !empty($request_id)) {   
    
    // --- NEW: FETCH REQUEST DATA FOR NOTIFICATION ---
    $req_query = $conn->query("SELECT barangay_id, service_type FROM service_requests WHERE id = '$request_id'");
    $req_data = $req_query->fetch_assoc();
    $target_brgy = $req_data['barangay_id'];
    $service = $req_data['service_type'];
    // ------------------------------------------------

    $sql = "UPDATE service_requests 
            SET status = '$status', 
                schedule_date = '$schedule_date' 
            WHERE id = '$request_id'";

    if ($conn->query($sql)) {
        
        // --- NEW: SEND NOTIFICATION TO BARANGAY ---
        if ($status === 'Approved') {
            $notif_msg = "Your request for '$service' has been Approved. Schedule: $schedule_date.";
        } else {
            $notif_msg = "Your request for '$service' was Rejected by the MSWDO.";
        }
        
        $notif_msg = mysqli_real_escape_string($conn, $notif_msg);
        
        // Match your 10-column table structure
        $notif_sql = "INSERT INTO notifications 
                      (barangay_id, pwd_id, user_type, message, status, created_at, read_by_admin, read_by_brgy, read_by_pwd) 
                      VALUES 
                      ('$target_brgy', NULL, 'barangay', '$notif_msg', 'unread', NOW(), 1, 0, 0)";
        
        $conn->query($notif_sql);
        // ------------------------------------------

        echo "success"; 
        exit();
    } else {
        echo "Database Error: " . $conn->error;
        exit();
    }
} else {
    echo "invalid_request";
    exit();
}
?>