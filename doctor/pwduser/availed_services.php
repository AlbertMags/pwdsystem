<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include("../db_connect.php");

if (!isset($_SESSION['related_pwd_id'])) { exit("Access Denied."); }

$session_id = $_SESSION['related_pwd_id'];

$query = "SELECT program_name, remarks, date_encoded FROM distribution_logs WHERE pwd_id = ? ORDER BY date_encoded DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $session_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
    .modal-log-list { display: flex; flex-direction: column; gap: 15px; text-align: left; }
    .modal-log-card {
        background: #fff; border: 1px solid #edf2f7; border-radius: 12px;
        padding: 20px; display: flex; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    .modal-log-date { text-align: center; min-width: 70px; border-right: 2px solid #f1f1f1; margin-right: 20px; padding-right: 15px; }
    .modal-log-date .day { display: block; font-size: 24px; font-weight: 800; color: #da7d0a; line-height: 1; }
    .modal-log-date .month { font-size: 11px; text-transform: uppercase; color: #7f8c8d; }
    .modal-log-info { flex-grow: 1; }
    .modal-log-info h3 { margin: 0 0 5px 0; color: #1a3a5f; font-size: 17px; }
    .modal-log-info p { margin: 0; font-size: 13px; color: #666; }
    .modal-status-badge { background: #e6fffa; color: #38a169; padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; white-space: nowrap; }
</style>

<div style="margin-bottom: 25px; border-left: 4px solid #da7d0a; padding-left: 15px;">
    <h2 style="margin:0; color:#1a3a5f;">My Availed Services</h2>
    <p style="margin:0; color:#7f8c8d; font-size: 14px;">History of programs and assistance received.</p>
</div>

<div class="modal-log-list">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="modal-log-card">
                <div class="modal-log-date">
                    <span class="day"><?= date('d', strtotime($row['date_encoded'])) ?></span>
                    <span class="month"><?= date('M Y', strtotime($row['date_encoded'])) ?></span>
                </div>
                <div class="modal-log-info">
                    <h3><?= htmlspecialchars($row['program_name']) ?></h3>
                    <p><?= htmlspecialchars($row['remarks'] ?: 'Claimed successfully.') ?></p>
                </div>
                <div class="modal-status-badge"><i class="fas fa-check-circle"></i> RECEIVED</div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div style="text-align:center; padding: 50px; color:#bbb;">
            <i class="fas fa-folder-open fa-3x" style="opacity:0.3; margin-bottom:15px;"></i>
            <p>No records found in your history.</p>
        </div>
    <?php endif; ?>
</div>