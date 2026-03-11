<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("db_connect.php");

// Validate that PWDs and a Program are selected
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pwd_ids']) && !empty($_POST['program_name'])) {
    
    // Determine the Program Name
    $program_name = ($_POST['program_name'] === 'Other') 
                    ? mysqli_real_escape_string($conn, $_POST['other_program_name']) 
                    : mysqli_real_escape_string($conn, $_POST['program_name']);

    // Fallback if "Other" was empty
    if(empty($program_name)) { 
        $program_name = "General Distribution"; 
    }

    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $pwd_ids = $_POST['pwd_ids']; 
    $success_count = 0;

    /* PREPARED STATEMENT:
       We pull the barangay_id directly from the 'pwd' table during the insert
       to ensure data integrity.
    */
    $stmt = $conn->prepare("INSERT INTO distribution_logs (pwd_id, barangay_id, program_name, remarks, date_encoded) 
                            SELECT id, barangay_id, ?, ?, NOW() FROM pwd WHERE id = ?");

    foreach ($pwd_ids as $id) {
        // Bind parameters: s = string, i = integer
        $stmt->bind_param("ssi", $program_name, $remarks, $id);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $success_count++;
            }
        }
    }

    $stmt->close();
    $conn->close();

    // Response for the AJAX success function
    if ($success_count > 0) {
        echo "success";
    } else {
        echo "error|No records were inserted.";
    }

} else {
    echo "invalid|Please select at least one PWD and a program.";
}
?>