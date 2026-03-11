<?php
session_start();
include("../db_connect.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['barangay_id'])) {
        die("Access Denied. Please log in.");
    }

    $barangay_id = $_SESSION['barangay_id'];
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    
    // 1. Correctly determine Service Type
    $service_type = "";
    if (isset($_POST['service_name']) && $_POST['service_name'] === "Other" && !empty($_POST['other_service_name'])) {
        $service_type = mysqli_real_escape_string($conn, $_POST['other_service_name']);
    } else {
        $service_type = mysqli_real_escape_string($conn, $_POST['service_name']);
    }

    if (isset($_POST['pwd_ids']) && is_array($_POST['pwd_ids'])) {
        $pwd_ids = $_POST['pwd_ids'];
        $success_count = 0;

        // 2. Insert Service Requests (Works with your Remarks)
        foreach ($pwd_ids as $pwd_id) {
            $pwd_id = mysqli_real_escape_string($conn, $pwd_id);
            $sql = "INSERT INTO service_requests (barangay_id, pwd_id, service_type, remarks, status, created_at) 
                    VALUES ('$barangay_id', '$pwd_id', '$service_type', '$remarks', 'Pending', NOW())";
            
            if ($conn->query($sql)) {
                $success_count++;
            }
        }

        // 3. Notification Logic (Mapped exactly to your 10-column table)
        if ($success_count > 0) {
            $b_res = $conn->query("SELECT brgy_name FROM barangay WHERE id = '$barangay_id'");
            $b_row = $b_res->fetch_assoc();
            $brgy_name = $b_row['brgy_name'] ?? 'Barangay';

            $notif_msg = "New Service Request: Brgy. $brgy_name requested '$service_type' for $success_count PWDs.";
            $notif_msg = mysqli_real_escape_string($conn, $notif_msg); // Safety first

            /**
             * Columns from your screenshot:
             * 1. id (Auto), 2. barangay_id, 3. pwd_id, 4. user_type, 5. message, 
             * 6. status, 7. created_at, 8. read_by_admin, 9. read_by_brgy, 10. read_by_pwd
             */
            $notif_sql = "INSERT INTO notifications 
                          (barangay_id, pwd_id, user_type, message, status, created_at, read_by_admin, read_by_brgy, read_by_pwd) 
                          VALUES 
                          ('$barangay_id', NULL, 'all', '$notif_msg', 'unread', NOW(), 0, 0, 0)";
            
            if (!$conn->query($notif_sql)) {
                // If this fails, we want to know WHY
                die("SQL Error: " . $conn->error);
            }
        }

      // ... (keep all your notification and insert logic the same)

        // REPLACE THE OLD SCRIPT ECHO WITH THIS:
        echo "success"; 
        exit();

    } else {
        echo "no_pwd_selected";
        exit();
    }
}