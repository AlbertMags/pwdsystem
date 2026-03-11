<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("db_connect.php");

/* Fetch Programs for the Modal */
$program_query = "SELECT title FROM services WHERE status='Active' ORDER BY created_at DESC";
$program_result = $conn->query($program_query);

/* Fetch Barangays for Filters */
$barangay_query = "SELECT * FROM barangay ORDER BY brgy_name ASC";
$barangay_result = $conn->query($barangay_query);

/* GET FILTER VALUES */
$filter_program = isset($_GET['program']) ? $_GET['program'] : '';
$filter_barangay = isset($_GET['barangay']) ? $_GET['barangay'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Distribution - ConnectAbilities</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body, html {
            background:#e9ecef;
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin:0;
            padding:0;
        }

        .top-nav {
            background:#fff;
            display:flex;
            align-items:center;
            padding:0 40px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
            position:fixed;
            top:0;
            left:250px;
            width:calc(100% - 250px);
            height:70px;
            z-index:1000;
        }

        .top-nav h1 { margin:0; font-size:22px; color:#1a3a5f; }
        .nav-sub { font-size:15px; color:#666; margin:0; }
        .dashboard-wrapper { padding:100px 25px 25px 25px; }
        .content-card { background:#fff; border-radius:12px; padding:30px; box-shadow:0 4px 20px rgba(0,0,0,0.05); min-height: 80vh; }

        /* TABS SYSTEM */
        .tab-container { display: flex; gap: 15px; margin-bottom: 25px; border-bottom: 2px solid #eee; }
        .tab-btn { 
            padding: 12px 25px; border: none; background: none; cursor: pointer; 
            font-weight: 600; color: #666; font-size: 16px; transition: 0.3s;
            border-bottom: 3px solid transparent; margin-bottom: -2px;
        }
        .tab-btn.active { color: #0056b3; border-bottom: 3px solid #0056b3; }
        .tab-content { display: none; animation: fadeIn 0.3s; }
        .tab-content.active { display: block; }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* BUTTONS */
        .button-program {
            background:#0056b3; color:white; border:none; padding:12px 20px; 
            border-radius:8px; cursor:pointer; font-weight:600; 
            display:inline-flex; align-items:center; gap:10px; font-size:15px;
        }
        .btn-approve { background: #28a745; color: white; padding: 8px 12px; border-radius: 5px; border:none; cursor:pointer; font-size: 12px; font-weight: 600; }
        .btn-reject { background: #dc3545; color: white; padding: 8px 12px; border-radius: 5px; border:none; cursor:pointer; font-size: 12px; font-weight: 600; text-decoration: none; text-align: center; display: inline-block;}
        .btn-release { background: #007bff; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 13px; font-weight: 600; display:inline-block; border: none; cursor: pointer; }
        
        .filter-bar { display:flex; align-items:center; gap:10px; margin-bottom:20px; flex-wrap:wrap; }
        .filter-bar select { padding:8px; border-radius:6px; border:1px solid #ccc; }

        /* TABLES */
        table { width:100%; border-collapse:collapse; margin-top: 10px; font-size: 14px; }
        thead { background:#f8f9fa; }
        th, td { padding:15px 12px; text-align:left; border-bottom:1px solid #eee; vertical-align: middle; }
        
        .status-badge { padding: 5px 10px; border-radius: 4px; font-size: 11px; font-weight: bold; text-transform: uppercase; display: inline-block; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-approved { background: #d4edda; color: #155724; }
        .badge-rejected { background: #f8d7da; color: #721c24; }
        .badge-done { background: #007bff !important; color: #fff !important; }

        /* CLICKABLE NAME STYLING */
        .clickable-name { color: #000; text-decoration: none; font-weight: bold; cursor: pointer; }
        .clickable-name:hover { text-decoration: underline; color: #0056b3; }

        /* PWD PROFILE MODAL STYLING */
        .pwd-modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 9999;
            overflow: hidden;
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

        /* DISTRIBUTION MODAL */
        .modal { display:none; position:fixed; z-index:2000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); }
        .modal-body-content { background:white; margin:2% auto; padding:30px; border-radius:10px; width:80%; max-height:90vh; overflow:auto; position: relative;}
        .close { float:right; font-size:28px; cursor:pointer; color: #999; }
        
        .sched-container { display: flex; flex-direction: column; gap: 8px; width: 230px; }
        .sched-input { padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 12px; width: 100%; box-sizing: border-box; }
        .action-btns { display: flex; gap: 5px; }
    </style>
</head>

<body>

<header class="top-nav">
    <div>
        <h1>Program Distribution</h1>
        <p class="nav-sub">Manage assistance distribution and barangay service requests.</p>
    </div>
</header>

<div class="dashboard-wrapper">
    <main class="content-card">

        <div class="tab-container">
            <button class="tab-btn active" id="btnHistory" onclick="openTab(event, 'historyTab')"><i class="fas fa-list-ul"></i> Distribution History</button>
            <button class="tab-btn" id="btnRequests" onclick="openTab(event, 'requestsTab')"><i class="fas fa-hand-holding-heart"></i> Barangay Service Requests</button>
        </div>

       <div id="historyTab" class="tab-content active">
    <form method="GET">
        <input type="hidden" name="page" value="program_distribution">
        <div class="filter-bar">
            <button type="button" class="button-program" onclick="openDistributionModal()">
                <i class="fas fa-plus"></i> New Admin Distribution
            </button>

            <select name="program" onchange="this.form.submit()">
                <option value="">All Programs</option>
                <?php
                $program_list = $conn->query("SELECT DISTINCT program_name FROM distribution_logs ORDER BY program_name ASC");
                while($p = $program_list->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($p['program_name']) ?>" <?= ($filter_program == $p['program_name']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['program_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <select name="barangay" onchange="this.form.submit()">
                <option value="">All Barangays</option>
                <?php 
                $barangay_result->data_seek(0);
                while($b = $barangay_result->fetch_assoc()): ?>
                    <option value="<?= $b['id'] ?>" <?= ($filter_barangay == $b['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($b['brgy_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th width="150">Date Encoded</th>
                <th width="150">Barangay</th>
                <th>Program / Service</th> <th>Recipient</th> <th width="200">Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $log_query = "SELECT l.*, p.id AS pid, p.first_name, p.last_name, b.brgy_name
                          FROM distribution_logs l
                          JOIN pwd p ON l.pwd_id = p.id
                          JOIN barangay b ON l.barangay_id = b.id
                          WHERE 1=1";

            if($filter_program != "") {
                $log_query .= " AND l.program_name = '" . mysqli_real_escape_string($conn, $filter_program) . "'";
            }
            if($filter_barangay != "") {
                $log_query .= " AND b.id = '" . mysqli_real_escape_string($conn, $filter_barangay) . "'";
            }
            
            $log_query .= " ORDER BY l.date_encoded DESC";
            $log_res = $conn->query($log_query);

            if($log_res && $log_res->num_rows > 0):
                while($log = $log_res->fetch_assoc()): ?>
                <tr>
                    <td><?= date("M d, Y", strtotime($log['date_encoded'])) ?><br>
                        <small style="color:#888;"><?= date("h:i A", strtotime($log['date_encoded'])) ?></small>
                    </td>

                    <td><b><?= htmlspecialchars($log['brgy_name']) ?></b></td>

                    <td><strong><?= htmlspecialchars($log['program_name']) ?></strong></td>

                    <td>
                        <span class="clickable-name" data-id="<?= $log['pid'] ?>">
                            <?= strtoupper($log['last_name'] . ", " . $log['first_name']) ?>
                        </span>
                    </td>

                    <td><small><?= htmlspecialchars($log['remarks']) ?></small></td>
                </tr>
            <?php endwhile; else: ?>
                <tr>
                    <td colspan="5" align="center" style="padding:40px; color:#999;">
                        No distribution history found matching your filters.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div id="requestsTab" class="tab-content">
    <h3 style="color:#1a3a5f; margin-bottom:15px;">Manage Incoming Barangay Requests</h3>
    <table>
        <thead>
            <tr>
                <th width="120">Date Requested</th>
                <th width="120">Barangay</th>
                <th width="200">Service Requested</th> <th width="180">Beneficiary</th> <th width="100">Status</th>
                <th width="250">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $req_sql = "SELECT r.*, p.id AS pid, p.first_name, p.last_name, b.brgy_name 
                        FROM service_requests r 
                        JOIN pwd p ON r.pwd_id = p.id 
                        JOIN barangay b ON r.barangay_id = b.id 
                        WHERE r.status IN ('Pending', 'Approved') 
                        ORDER BY FIELD(r.status, 'Pending', 'Approved'), r.created_at DESC";
            
            $req_res = $conn->query($req_sql);

            if($req_res && $req_res->num_rows > 0):
                while($r = $req_res->fetch_assoc()): 
                    $status = $r['status'];
                ?>
                <tr>
                    <td><?= date("M d, Y", strtotime($r['created_at'])) ?></td>
                    <td><b><?= htmlspecialchars($r['brgy_name']) ?></b></td>
                    
                    <td><strong><?= htmlspecialchars($r['service_type']) ?></strong></td>
                    
                    <td>
                        <span class="clickable-name" data-id="<?= $r['pid'] ?>">
                            <?= strtoupper($r['last_name'].", ".$r['first_name']) ?>
                        </span>
                    </td>

                    <td>
                        <span class="status-badge <?= ($status == 'Pending') ? 'badge-pending' : 'badge-approved' ?>">
                            <?= $status ?>
                        </span>
                    </td>
                    <td>
                        <?php if($status == 'Pending'): ?>
                            <form class="ajax-approval-form sched-container">
                                <input type="hidden" name="request_id" value="<?= $r['id'] ?>">
                                <input type="text" name="schedule_date" class="sched-input" placeholder="e.g. Oct 10, 9AM at Plaza">
                                
                                <div class="action-btns">
                                    <button type="button" onclick="submitApproval(this, 'approve')" class="btn-approve">
                                        <i class="fas fa-calendar-check"></i> Approve
                                    </button>
                                    
                                    <button type="button" onclick="submitApproval(this, 'reject')" class="btn-reject">
                                        Reject
                                    </button>
                                </div>
                            </form>
                        <?php else: // Status is Approved ?>
                            <div style="margin-bottom: 8px;">
                                <small style="color:#007bff; display:block; margin-bottom:5px;">
                                    <i class="fas fa-clock"></i> <?= htmlspecialchars($r['schedule_date']) ?>
                                </small>
                                <button type="button" class="btn-release" onclick="markAsReleased(<?= $r['id'] ?>)">
                                    <i class="fas fa-check-circle"></i> Mark Released
                                </button>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; else: ?>
                <tr><td colspan="6" align="center" style="padding:40px; color:#888;">No active requests found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

    </main>
</div>

<div id="distributionModal" class="modal">
    <div class="modal-body-content">
        <span class="close" onclick="closeDistributionModal()">&times;</span>
        <h2>New Program Distribution (Direct Entry)</h2>
        <form id="bulkDistributionForm">
            <br>
            <label><b>Select Program</b></label>
            <select name="program_name" id="programSelect" onchange="toggleOtherInput()" required style="width:100%; padding:10px; margin-top:5px; border: 1px solid #ccc; border-radius: 6px;">
                <option value="">-- Choose Program --</option>
                <?php
                $program_result->data_seek(0);
                while($p=$program_result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($p['title']) ?>"><?= htmlspecialchars($p['title']) ?></option>
                <?php endwhile; ?>
                <option value="Other">Other</option>
            </select>

            <div id="otherInputDiv" style="display:none; margin-top:10px;">
                <input type="text" name="other_program_name" placeholder="Enter Program Name" style="width:100%; padding:10px; border: 1px solid #ccc; border-radius: 6px;">
            </div>

            <br><br>
            <label><b>Remarks</b></label>
            <input type="text" name="remarks" style="width:100%; padding:10px; border: 1px solid #ccc; border-radius: 6px;" placeholder="e.g. 5kg Rice, Medical Kit">

            <br><br>
            <div style="max-height: 350px; overflow: auto; border: 1px solid #ddd; border-radius: 8px;">
                <table>
                    <thead style="position: sticky; top: 0; background: #f8f9fa;">
                        <tr>
                            <th width="40"><input type="checkbox" id="selectAll"></th>
                            <th>PWD Name</th>
                            <th>Barangay</th>
                            <th>Disability</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pwd_query = "SELECT p.id, p.first_name, p.last_name, b.brgy_name, d.disability_name
                                      FROM pwd p
                                      JOIN barangay b ON p.barangay_id=b.id
                                      JOIN disability_type d ON p.disability_type=d.id
                                      WHERE p.status='Official'
                                      ORDER BY b.brgy_name, p.last_name";
                        $pwd_result = $conn->query($pwd_query);
                        while($row=$pwd_result->fetch_assoc()): ?>
                        <tr>
                            <td><input type="checkbox" name="pwd_ids[]" value="<?= $row['id'] ?>" class="pwd-checkbox"></td>
                            <td>
                                <span class="clickable-name" data-id="<?= $row['id'] ?>">
                                    <?= strtoupper($row['last_name'].", ".$row['first_name']) ?>
                                </span>
                            </td>
                            <td><?= $row['brgy_name'] ?></td>
                            <td><?= $row['disability_name'] ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <br>
            <button type="submit" class="button-program" style="width:100%; justify-content:center; padding:15px; border-radius: 10px;">
                <i class="fas fa-save"></i> Save & Execute Distribution
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
    // 1. Handle URL/Session for Tabs
    const urlParams = new URLSearchParams(window.location.search);
    const urlTab = urlParams.get('tab');
    let lastTab = sessionStorage.getItem('activeTab');

    if (urlTab === 'requests' || lastTab === 'requestsTab') {
        $("#btnRequests").addClass("active");
        $("#btnHistory").removeClass("active");
        $("#requestsTab").show();
        $("#historyTab").hide();
        if(urlTab) {
            window.history.replaceState({}, document.title, "index.php?page=program_distribution");
        }
    }

    // 2. Profile View Logic (Modal with Iframe)
    $(document).on("click", ".clickable-name", function() {
        var id = $(this).data("id");
        openProfileModal("view_pwd.php?id=" + id);
    });

    window.openProfileModal = function(url) {
        $("#viewFrame").attr("src", url);
        $(".pwd-modal-backdrop").fadeIn();
        $("body").addClass("no-scroll");
    }

    function closeProfileModal() {
        $(".pwd-modal-backdrop").fadeOut();
        $("body").removeClass("no-scroll");
        setTimeout(function() {
            $("#viewFrame").attr("src", "");
        }, 300);
    }

    $(".close-view").click(function() { closeProfileModal(); });

    $(document).keyup(function(e) {
        if (e.key === "Escape") closeProfileModal();
    });
});

function openTab(evt, tabName) {
    sessionStorage.setItem('activeTab', tabName);
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) { tabcontent[i].style.display = "none"; }
    tablinks = document.getElementsByClassName("tab-btn");
    for (i = 0; i < tablinks.length; i++) { tablinks[i].className = tablinks[i].className.replace(" active", ""); }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

function openDistributionModal(){ document.getElementById("distributionModal").style.display="block"; }
function closeDistributionModal(){ document.getElementById("distributionModal").style.display="none"; }

function toggleOtherInput(){
    const select = document.getElementById("programSelect");
    const otherDiv = document.getElementById("otherInputDiv");
    otherDiv.style.display = (select.value === "Other") ? "block" : "none";
}

document.getElementById("selectAll").addEventListener("change", function() {
    let checkboxes = document.querySelectorAll(".pwd-checkbox");
    checkboxes.forEach(cb => cb.checked = this.checked);
});

// Bulk Distribution logic
$("#bulkDistributionForm").on("submit", function(e) {
    e.preventDefault(); 
    $.ajax({
        url: "save_bulk_distribution.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(response) {
            if(response.includes("success")) {
                location.reload(); 
            } else {
                alert("Update failed: " + response);
            }
        },
    });
});

function submitApproval(btn, actionType) {
    let form = $(btn).closest('form');
    let schedInput = form.find('.sched-input');

    if(actionType === 'approve') {
        if(schedInput.val().trim() === ""){
            alert("Please enter a schedule date/location before approving.");
            schedInput.focus();
            return;
        }
    } else if(actionType === 'reject') {
        if(!confirm('Are you sure you want to reject this request?')) return;
    }

    let formData = form.serialize() + "&action=" + actionType;

    $.ajax({
        url: "process_approval.php",
        type: "POST",
        data: formData,
        success: function(response) {
            alert("Request successfully updated.");
            location.reload(); 
        },
        error: function() {
            alert("An error occurred during the process.");
        }
    });
}

function markAsReleased(requestId) {
    if(!confirm('Confirm Release?')) return;

    $.ajax({
        url: "process_release.php",
        type: "GET",
        data: { id: requestId },
        success: function(response) {
            alert("Marked as Released!");
            location.reload();
        },
        error: function() {
            alert("An error occurred.");
        }
    });
}
</script>

</body>
</html>