<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("db_connect.php");

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $request_id = mysqli_real_escape_string($conn, $_GET['id']);

    // 1. Fetch details to copy to distribution_logs
    $fetch_sql = "SELECT * FROM service_requests WHERE id = '$request_id' LIMIT 1";
    $result = $conn->query($fetch_sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        $pwd_id = $row['pwd_id'];
        $barangay_id = $row['barangay_id'];
        $program_name = $row['service_type'];
        $remarks = "Released from Barangay Request: " . $row['remarks'];
        $dist_date = date('Y-m-d H:i:s');

        $conn->begin_transaction();

        try {
            // A. Insert into history logs
            $log_sql = "INSERT INTO distribution_logs (pwd_id, barangay_id, program_name, remarks, date_encoded) 
                        VALUES ('$pwd_id', '$barangay_id', '$program_name', '$remarks', '$dist_date')";
            $conn->query($log_sql);

            // B. Update status to 'Released'
            $update_sql = "UPDATE service_requests SET status = 'Released' WHERE id = '$request_id'";
            $conn->query($update_sql);

            $conn->commit();

            echo "<script>
                    alert('Service successfully Released and recorded in History!');
                    window.location.href = 'index.php?page=program_distribution';
                  </script>";
        } catch (Exception $e) {
            $conn->rollback();
            echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href = 'index.php?page=program_distribution';</script>";
        }
    }
} else {
    header("Location: index.php?page=program_distribution");
    exit();
}
?>