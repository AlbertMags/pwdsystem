<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("../db_connect.php"); 

// Check if user is logged in and has a barangay ID
if (!isset($_SESSION['barangay_id'])) {
    echo "Access Denied. Please log in.";
    exit();
}

$my_barangay_id = $_SESSION['barangay_id'];

/* Fetch Barangay Name for Header */
$brgy_info = $conn->query("SELECT brgy_name FROM barangay WHERE id = '$my_barangay_id'")->fetch_assoc();
$my_brgy_name = $brgy_info['brgy_name'] ?? 'Barangay';

/* Fetch Active Services for the Request Modal */
$program_query = "SELECT title FROM services WHERE status='Active' ORDER BY created_at DESC";
$program_result = $conn->query($program_query);

/* GET FILTER VALUES */
$filter_program = isset($_GET['program']) ? $_GET['program'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Management - <?= htmlspecialchars($my_brgy_name) ?></title>

    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body, html {
            background: #e9ecef;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .top-nav {
            background: #fff;
            display: flex;
            align-items: center;
            padding: 0 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 250px;
            width: calc(100% - 250px);
            height: 70px;
            z-index: 1000;
        }

        .top-nav h1 { margin: 0; font-size: 22px; color: #1a3a5f; }
        .nav-sub { font-size: 14px; color: #666; margin: 0; }
        .dashboard-wrapper{ padding:100px 25px 25px 25px; }
        .content-card { background: #fff; border-radius: 12px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); min-height: 80vh; }

        .tab-container { display: flex; gap: 10px; margin-bottom: 25px; border-bottom: 2px solid #eee; }
        .tab-btn {
            padding: 12px 25px; border: none; background: none; cursor: pointer;
            font-weight: 600; color: #888; transition: 0.3s; border-bottom: 3px solid transparent; font-size: 14px;
        }
        .tab-btn i { margin-right: 8px; }
        .tab-btn.active { color: #007bff; border-bottom: 3px solid #007bff; }
        .tab-content { display: none; animation: fadeIn 0.3s; }
        .tab-content.active { display: block; }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .button-request {
            background: #0056b3;  color: white; border: none; padding: 10px 18px;
            border-radius: 8px; cursor: pointer; font-weight: 600; display: inline-flex;
            align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; margin-bottom: 20px;
        }
        .button-request:hover { background: #218838; }

        table { width:100%; border-collapse:collapse; margin-top: 10px; font-size: 14px; }
        thead { background:#f8f9fa; }
        th, td { padding:15px 12px; text-align:left; border-bottom:1px solid #eee; vertical-align: middle; }
        
        /* CLICKABLE NAME STYLING */
        .clickable-name { color: #000; text-decoration: none; font-weight: bold; cursor: pointer; }
        .clickable-name:hover { text-decoration: underline; color: #0056b3; }

        /* MODALS */
        .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
        .modal-content {
            background: white; margin: 3% auto; padding: 30px; border-radius: 12px;
            width: 75%; max-height: 90vh; overflow-y: auto; box-shadow: 0 5px 30px rgba(0,0,0,0.3);
        }
        .close { float: right; font-size: 28px; font-weight: bold; cursor: pointer; color: #aaa; }

        /* STATUS BADGES */
        .status-badge { padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: bold; display: inline-block; text-transform: uppercase; }
        .status-pending { background: #ffeeba; color: #856404; }
        .status-approved { background: #d4edda; color: #155724; }
        
        .pwd-list-container { max-height: 300px; overflow-y: auto; border: 1px solid #eee; border-radius: 8px; margin-top: 10px; }
        .schedule-info { display: block; margin-top: 5px; font-size: 11px; color: #007bff; font-weight: 600; }

        /* PWD PROFILE MODAL (IFRAME) */
        .pwd-modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 9999;
        }
        .pwd-modal-content {
            position: relative;
            background: #fff;
            width: 95%;
            max-width: 1100px;
            margin: 2vh auto;
            border-radius: 8px;
            height: 96vh;
            overflow: hidden;
            box-shadow: 0 0 30px rgba(0,0,0,0.5);
        }
        .close-view {
            position: absolute;
            right: 25px;
            top: 15px;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            color: #333;
            z-index: 10001;
        }
        .no-scroll { overflow: hidden !important; }
    </style>
</head>

<body>
<?php include("includes/brgy_sidebar.php"); ?>

<header class="top-nav">
    <div>
        <h1>Service Management</h1>
        <p class="nav-sub">Official Records for <b>Barangay <?= htmlspecialchars($my_brgy_name) ?></b></p>
    </div>
</header>

<div class="dashboard-wrapper">
    <main class="content-card">
        
        <button type="button" class="button-request" onclick="openRequestModal()">
            <i class="fas fa-plus"></i> Request Service / Assistance
        </button>

        <div class="tab-container">
            <button id="btn-history" class="tab-btn active" onclick="switchTab(event, 'main-logs')">
                <i class="fas fa-history"></i> Distribution History
            </button>
            <button id="btn-track" class="tab-btn" onclick="switchTab(event, 'my-requests')">
                <i class="fas fa-paper-plane"></i> Track My Requests
            </button>
        </div>

        <div id="main-logs" class="tab-content active">
            <div class="filter-bar" style="margin-bottom: 15px;">
                <form method="GET">
                    <input type="hidden" name="page" value="brgy_program_history">
                    <label style="font-size: 14px; color: #666;">Filter Program:</label>
                    <select name="program" onchange="this.form.submit()" style="padding: 8px; border-radius: 6px; border: 1px solid #ccc;">
                        <option value="">All Programs</option>
                        <?php
                        $p_list = $conn->query("SELECT DISTINCT program_name FROM distribution_logs WHERE barangay_id = '$my_barangay_id' ORDER BY program_name ASC");
                        while($p = $p_list->fetch_assoc()):
                        ?>
                        <option value="<?= htmlspecialchars($p['program_name']) ?>" <?= ($filter_program==$p['program_name'])?'selected':'' ?>>
                            <?= htmlspecialchars($p['program_name']) ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th width="150">Date Received</th>
                        <th>Program / Service</th>
                        <th>Recipient</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $log_sql = "SELECT l.*, p.id AS pid, p.first_name, p.last_name FROM distribution_logs l JOIN pwd p ON l.pwd_id = p.id WHERE l.barangay_id = '$my_barangay_id'";
                    if($filter_program) $log_sql .= " AND l.program_name='".mysqli_real_escape_string($conn, $filter_program)."'";
                    $log_sql .= " ORDER BY l.date_encoded DESC";
                    $res = $conn->query($log_sql);
                    if($res && $res->num_rows > 0):
                        while($l = $res->fetch_assoc()): ?>
                        <tr>
                            <td><?= date("M d, Y", strtotime($l['date_encoded'])) ?></td>
                            <td><b><?= htmlspecialchars($l['program_name']) ?></b></td>
                            <td>
                                <span class="clickable-name" data-id="<?= $l['pid'] ?>">
                                    <?= strtoupper(htmlspecialchars($l['last_name'].", ".$l['first_name'])) ?>
                                </span>
                            </td>
                            <td><small><?= htmlspecialchars($l['remarks']) ?></small></td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="4" align="center" style="padding:40px; color:#999;">No distribution records found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div id="my-requests" class="tab-content">
            <table>
                <thead>
                    <tr>
                        <th width="150">Date Requested</th>
                        <th>Service</th>
                        <th>Beneficiary</th>
                        <th>Status / Schedule</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $req_sql = "SELECT r.*, p.id AS pid, p.first_name, p.last_name FROM service_requests r JOIN pwd p ON r.pwd_id = p.id WHERE r.barangay_id = '$my_barangay_id' AND r.status IN ('Pending', 'Approved') ORDER BY FIELD(r.status, 'Pending', 'Approved'), r.created_at DESC";
                    $req_res = $conn->query($req_sql);
                    if($req_res && $req_res->num_rows > 0):
                        while($r = $req_res->fetch_assoc()):
                            $s_class = ($r['status'] == 'Approved') ? 'status-approved' : 'status-pending';
                    ?>
                    <tr>
                        <td><?= date("M d, Y", strtotime($r['created_at'])) ?></td>
                        <td><b><?= htmlspecialchars($r['service_type']) ?></b></td>
                        <td>
                            <span class="clickable-name" data-id="<?= $r['pid'] ?>">
                                <?= strtoupper(htmlspecialchars($r['last_name'].", ".$r['first_name'])) ?>
                            </span>
                        </td>
                        <td>
                            <span class="status-badge <?= $s_class ?>"><?= $r['status'] ?></span>
                            <?php if($r['status'] == 'Approved' && !empty($r['schedule_date'])): ?>
                                <span class="schedule-info"><i class="fas fa-clock"></i> <?= htmlspecialchars($r['schedule_date']) ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="4" align="center" style="padding:40px; color:#999;">No active requests found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<div id="requestModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeRequestModal()">&times;</span>
        <h2><i class="fas fa-paper-plane"></i> Submit Service Request</h2>
        <form id="brgyRequestForm">
            <input type="hidden" name="barangay_id" value="<?= $my_barangay_id ?>">
            <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                <div style="flex:1;">
                    <label><b>Requested Service</b></label>
                    <select name="service_name" id="serviceSelect" onchange="toggleOtherInput()" required style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc; margin-top:5px;">
                        <option value="">-- Select --</option>
                        <?php 
                        $program_result->data_seek(0);
                        while($p = $program_result->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($p['title']) ?>"><?= htmlspecialchars($p['title']) ?></option>
                        <?php endwhile; ?>
                        <option value="Other">Other</option>
                    </select>
                    <input type="text" id="otherInputDiv" name="other_service_name" placeholder="Specify Program Name..." style="display:none; width:95%; margin-top:10px; padding:10px; border:1px solid #ccc; border-radius:6px;">
                </div>
                <div style="flex:1;">
                    <label><b>Remarks</b></label>
                    <input type="text" name="remarks" placeholder="e.g. Requesting medical assistance" required style="width:100%; padding:10px; border-radius:6px; border:1px solid #ccc; margin-top:5px;">
                </div>
            </div>

            <label><b>Select PWD Beneficiaries</b></label>
            <div class="pwd-list-container">
                <table>
                    <thead style="position: sticky; top: 0; background: #f8f9fa;">
                        <tr>
                            <th width="40"><input type="checkbox" id="selectAll"></th>
                            <th>Full Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pwds = $conn->query("SELECT id, first_name, last_name FROM pwd WHERE barangay_id='$my_barangay_id' AND status='Official' ORDER BY last_name ASC");
                        while($row = $pwds->fetch_assoc()): ?>
                            <tr>
                                <td><input type="checkbox" name="pwd_ids[]" value="<?= $row['id'] ?>" class="pwd-checkbox"></td>
                                <td>
                                    <span class="clickable-name" data-id="<?= $row['id'] ?>">
                                        <?= strtoupper(htmlspecialchars($row['last_name'].", ".$row['first_name'])) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <button type="submit" class="button-request" style="width:100%; margin-top:20px; justify-content:center; padding:15px; border-radius: 10px;">
                <i class="fas fa-save"></i> Submit Request to MSWDO
            </button>
        </form>
    </div>
</div>

<div class="pwd-modal-backdrop">
    <div class="pwd-modal-content">
        <span class="close-view">&times;</span>
        <iframe id="viewFrame" src="" style="width: 100%; height: 100%; border: none; display: block;"></iframe>
    </div>
</div>

<script>
$(document).ready(function() {
    // --- PERSISTENT TAB LOGIC ---
    const urlParams = new URLSearchParams(window.location.search);
    const urlTab = urlParams.get('tab');
    const savedTab = localStorage.getItem('activeTab_BrgyProg');

    if (urlTab === 'track') {
        switchTab(null, 'my-requests');
        window.history.replaceState({}, document.title, window.location.pathname);
    } else if (savedTab) {
        switchTab(null, savedTab);
    }

    // --- PROFILE VIEW LOGIC (Iframe) ---
    $(document).on("click", ".clickable-name", function() {
        var id = $(this).data("id");
        openProfileModal("../view_pwd.php?id=" + id);
    });

    window.openProfileModal = function(url) {
        $("#viewFrame").attr("src", url);
        $(".pwd-modal-backdrop").fadeIn();
        $("body").addClass("no-scroll");
    }

    function closeProfileModal() {
        $(".pwd-modal-backdrop").fadeOut();
        $("body").removeClass("no-scroll");
        setTimeout(function() { $("#viewFrame").attr("src", ""); }, 300);
    }

    $(".close-view").click(function() { closeProfileModal(); });

    $(document).keyup(function(e) {
        if (e.key === "Escape") {
            closeProfileModal();
            closeRequestModal();
        }
    });

    // --- AJAX FORM SUBMISSION ---
    $("#brgyRequestForm").on("submit", function(e) {
        e.preventDefault(); 
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true).html("<i class='fas fa-spinner fa-spin'></i> Processing...");

        $.ajax({
            url: "save_brgy_request.php",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                const result = response.trim();
                if(result === "success") {
                    alert("Success! Your request has been sent to MSWDO.");
                    localStorage.setItem('activeTab_BrgyProg', 'my-requests');
                    window.location.href = window.location.pathname + "?tab=track";
                } else {
                    alert("Submission Failed: " + result);
                    submitBtn.prop('disabled', false).html(originalText);
                }
            },
            error: function() {
                alert("Network error. Please check your connection.");
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
});

function switchTab(evt, tabName) {
    $(".tab-content").removeClass("active").hide();
    $(".tab-btn").removeClass("active");
    $("#" + tabName).addClass("active").show(); 

    if (evt) {
        $(evt.currentTarget).addClass("active");
    } else {
        $(`.tab-btn[onclick*="${tabName}"]`).addClass("active");
    }
    localStorage.setItem('activeTab_BrgyProg', tabName);
}

function openRequestModal(){ $("#requestModal").fadeIn(); }
function closeRequestModal(){ $("#requestModal").fadeOut(); }

function toggleOtherInput(){
    $("#otherInputDiv").toggle($("#serviceSelect").val() === "Other");
}

$("#selectAll").on("change", function(){
    $(".pwd-checkbox").prop("checked", this.checked);
});

window.onclick = function(event) {
    if ($(event.target).hasClass('modal')) closeRequestModal();
    if ($(event.target).hasClass('pwd-modal-backdrop')) closeProfileModal();
}
</script>

</body>
</html>