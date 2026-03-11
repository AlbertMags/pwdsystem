<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("db_connect.php");

// ... [Keep your POST processing logic here] ...
?>

<div class="card shadow-sm border-0 mt-3">
    <div class="card-body">
        <h4 class="mb-4 text-primary"><i class="fas fa-list-ul me-2"></i>Resident Service Applications</h4>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Date Requested</th>
                        <th>Barangay</th>
                        <th>Service & Beneficiary</th>
                        <th>Details (Date/Time/Location)</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT r.*, p.first_name, p.last_name, b.brgy_name 
                              FROM service_requests r 
                              LEFT JOIN pwd p ON r.pwd_id = p.id 
                              LEFT JOIN barangay b ON r.barangay_id = b.id
                              ORDER BY r.created_at DESC";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0):
                        while ($row = mysqli_fetch_assoc($result)):
                            $status = $row['status'];
                            
                            // SET TEXT AND COLOR LOGIC
                            $status_text = $status;
                            $status_class = 'bg-warning text-dark';

                            if ($status == 'Approved') {
                                $status_class = 'bg-success';
                            } elseif ($status == 'Released') {
                                $status_text = 'DONE'; // Force text to "DONE"
                                $status_class = 'bg-primary';
                            } elseif ($status == 'Rejected' || $status == 'Declined') {
                                $status_class = 'bg-danger';
                            }
                    ?>
                    <tr>
                        <td><?php echo date("M d, Y", strtotime($row['created_at'])); ?></td>
                        <td><strong><?php echo htmlspecialchars($row['brgy_name']); ?></strong></td>
                        <td>
                            <b><?php echo htmlspecialchars($row['service_type']); ?></b><br>
                            <small class="text-muted">For: <?php echo strtoupper($row['last_name'] . ", " . $row['first_name']); ?></small>
                        </td>
                        <td>
                            <?php if ($status == 'Pending'): ?>
                                <form method="POST" action="requested_service.php" class="d-flex flex-column gap-1">
                                    <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="process_request" value="1">
                                    <input type="text" name="schedule_details" class="form-control form-control-sm" placeholder="Details..." required>
                                    <div class="btn-group w-100">
                                        <button type="submit" name="action" value="approve" class="btn btn-sm btn-success">Approve</button>
                                        <button type="submit" name="action" value="decline" class="btn btn-sm btn-danger">Reject</button>
                                    </div>
                                </form>
                            <?php else: ?>
                                <span class="text-primary fw-bold">
                                    <i class="fas fa-calendar-alt me-1"></i> 
                                    <?php echo (!empty($row['schedule_date']) && $row['schedule_date'] != '0000-00-00') ? htmlspecialchars($row['schedule_date']) : "N/A"; ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td><span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                        
                        <td class="text-center">
                            <?php if ($status == 'Approved'): ?>
                                <a href="process_release.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary" onclick="return confirm('Confirm Release?')">
                                    <i class="fas fa-check-circle"></i> Mark Released
                                </a>
                            <?php elseif ($status == 'Released'): ?>
                                <span class="text-success fw-bold"><i class="fas fa-check-double"></i> Released</span>
                            <?php else: ?>
                                <small class="text-muted">No Action</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">No resident applications found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>