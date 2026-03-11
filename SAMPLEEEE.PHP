<?php
session_start();
include("../db_connect.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['barangay_id'])) {
        die("Access Denied. Please log in.");
    }

    $barangay_id = $_SESSION['barangay_id'];
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    
    $service_type = "";
    if (!empty($_POST['other_service_name'])) {
        $service_type = mysqli_real_escape_string($conn, $_POST['other_service_name']);
    } else {
        $service_type = mysqli_real_escape_string($conn, $_POST['service_name']);
    }

    if (isset($_POST['pwd_ids']) && is_array($_POST['pwd_ids'])) {
        $pwd_ids = $_POST['pwd_ids'];
        $success_count = 0;

        foreach ($pwd_ids as $pwd_id) {
            $pwd_id = mysqli_real_escape_string($conn, $pwd_id);
            $sql = "INSERT INTO service_requests (barangay_id, pwd_id, service_type, remarks, status, created_at) 
                    VALUES ('$barangay_id', '$pwd_id', '$service_type', '$remarks', 'Pending', NOW())";
            
            if ($conn->query($sql)) {
                $success_count++;
            }
        }

        // FIXED: Redirect to the ROUTE 'brgy_program_history' without .php
        // This forces index.php to load the page with the sidebar correctly.
        echo "<script>
            alert('Successfully submitted $success_count requests to MSWDO.');
            window.location.href = 'brgy_program_history';
        </script>";
        exit();

    } else {
        echo "<script>
            alert('Error: Please select at least one PWD beneficiary.');
            window.location.href = 'brgy_program_history';
        </script>";
        exit();
    }
} else {
    // Also updated this fall-back redirect
    header("Location: brgy_program_history");
    exit();
}
?>