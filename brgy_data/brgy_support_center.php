<?php
include("../db_connect.php");

// Fetch announcements, services, and news from the database
$ann_list = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");
$serv_list = $conn->query("SELECT * FROM services WHERE status = 'Active' ORDER BY created_at DESC");
$news_list = $conn->query("SELECT * FROM news ORDER BY event_date DESC");

// Set active tab logic for PHP (Initial page load)
$active_tab = 'tab-ann';
if(isset($_GET['tab'])){
    if($_GET['tab'] == 'services') $active_tab = 'tab-serv';
    if($_GET['tab'] == 'news') $active_tab = 'tab-news';
}
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Support Center</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* --- CORE STYLING --- */
        * { box-sizing: border-box; }
        
        body, html { 
            background-color: #e9ecef; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; padding: 0; width: 100%; height: 100%;
        }

        /* --- UNIFIED NAVBAR --- */
        .top-nav {
            background: #fff; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            padding: 20px 40px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
            position: fixed; 
            top: 0; 
            left: 250px; 
            width: calc(100% - 250px); 
            z-index: 1000;
        }

        .nav-brand-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .nav-text-stack {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .top-nav h1 { 
            margin: 0; 
            color: #1a3a5f; 
            font-size: 22px; 
            font-weight: 700; 
            line-height: 1.2;
        }

        .nav-sub { 
            font-size: 16px; 
            color: #4b4848; 
            font-weight: normal; 
            margin: 0;
            line-height: 1.2;
        }

        /* --- LAYOUT & CONTENT --- */
        .dashboard-wrapper { 
            padding: 110px 25px 25px 25px; 
            width: 100%; 
        }

        .content-card {
            background: #fff; border-radius: 12px; padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); width: 100%;
        }

        /* --- TABS --- */
        .tabs { 
            display: flex; 
            justify-content: flex-start; 
            gap: 12px; 
            margin-bottom: 25px; 
            border-bottom: 2px solid #eee; 
            padding-bottom: 15px; 
        }

        .tab-btn { 
            padding: 10px 35px; 
            cursor: pointer; 
            border: none; 
            background: #f0f0f0; 
            border-radius: 6px; 
            font-weight: bold; 
            color: #555; 
            transition: 0.2s; 
        }
        .tab-btn.active { background: #3498db; color: white; }

        .content-section { display: none; width: 100%; }
        .content-section.active { display: block; }

        /* --- ITEM CARDS --- */
        .item-card { 
            background: white; 
            border-radius: 12px; 
            padding: 30px; 
            margin-bottom: 20px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            display: flex; 
            justify-content: space-between; 
            align-items: flex-start; 
            border: 1px solid #eee; 
            width: 100%;
        }

        .announcement-card { border-left: 8px solid #3498db; }
        .service-card { border-left: 8px solid #2ecc71; flex-direction: column; }
        .news-card { border-left: 8px solid #e67e22; }

        .service-cat {
            color: #3498db; 
            font-weight: bold; 
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        /* --- IMAGE HANDLING --- */
        .ann-image-wrapper {
            width: 300px; 
            height: 180px; 
            overflow: hidden; 
            border-radius: 10px;
            margin-left: 30px;
            flex-shrink: 0;
            border: 1px solid #eee;
        }

        .ann-image-wrapper img {
            width: 100%; 
            height: 100%; 
            object-fit: cover;
        }

        /* --- INFO GRID --- */
        .info-grid { 
            width: 100%; 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 20px; 
            margin-top: 20px; 
            background: #f9f9f9; 
            padding: 20px; 
            border-radius: 10px; 
            font-size: 14px; 
        }

        .info-grid div i {
            color: #3498db;
            margin-right: 8px;
        }

        @media (max-width: 992px) {
            .top-nav { left: 0; width: 100%; }
            .item-card { flex-direction: column; }
            .ann-image-wrapper { width: 100%; margin: 20px 0 0 0; }
        }
    </style>
</head>
<body>

    <header class="top-nav">
        <div class="nav-brand-wrapper">
            <div class="nav-text-stack">
                <h1>Support Center</h1>
                <p class="nav-sub">View community announcements, news, and available services.</p>
            </div>
        </div>
    </header>

    <div class="dashboard-wrapper">
        <main class="content-card">
            
            <div class="tabs">
                <button id="btn-ann" class="tab-btn <?= ($active_tab == 'tab-ann') ? 'active' : '' ?>" onclick="openTab('tab-ann')">Announcements</button>
                <button id="btn-news" class="tab-btn <?= ($active_tab == 'tab-news') ? 'active' : '' ?>" onclick="openTab('tab-news')">News & Activities</button>
                <button id="btn-serv" class="tab-btn <?= ($active_tab == 'tab-serv') ? 'active' : '' ?>" onclick="openTab('tab-serv')">Available Services</button>
            </div>

            <div id="tab-ann" class="content-section <?= ($active_tab == 'tab-ann') ? 'active' : '' ?>">
                <?php if($ann_list && $ann_list->num_rows > 0): ?>
                    <?php while($a = $ann_list->fetch_assoc()): ?>
                        <div class="item-card announcement-card">
                            <div style="flex:1;">
                                <div style="font-size: 1.8rem; font-weight: 700; color: #2c3e50;"><?= htmlspecialchars($a['title']) ?></div>
                                <div style="font-size: 0.9rem; color: #888; margin-bottom: 15px;">
                                    <i class="far fa-calendar-alt"></i> <?= date('F d, Y', strtotime($a['created_at'])) ?>
                                </div>
                                <p style="color: #444; line-height: 1.8; font-size: 16px;">
                                    <?= nl2br(htmlspecialchars($a['message'])) ?>
                                </p>
                            </div>
                            
                            <?php if(!empty($a['image'])): ?>
                                <div class="ann-image-wrapper">
                                    <img src="../uploads/announcements/<?= $a['image'] ?>" alt="Announcement Image">
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="item-card" style="justify-content: center; color: #999;">
                        <h3>No announcements available at the moment.</h3>
                    </div>
                <?php endif; ?>
            </div>

            <div id="tab-news" class="content-section <?= ($active_tab == 'tab-news') ? 'active' : '' ?>">
                <?php if($news_list && $news_list->num_rows > 0): ?>
                    <?php while($n = $news_list->fetch_assoc()): ?>
                        <div class="item-card news-card">
                            <div style="flex:1;">
                                <div style="font-size: 1.8rem; font-weight: 700; color: #2c3e50;"><?= htmlspecialchars($n['title']) ?></div>
                                <div style="font-size: 0.95rem; color: #e67e22; font-weight: bold; margin-bottom: 15px;">
                                    <i class="fas fa-calendar-check"></i> Event Date: <?= date('F d, Y', strtotime($n['event_date'])) ?>
                                </div>
                                <p style="color: #444; line-height: 1.8; font-size: 16px;">
                                    <?= nl2br(htmlspecialchars($n['content'])) ?>
                                </p>
                            </div>
                            
                            <?php if(!empty($n['image'])): ?>
                                <div class="ann-image-wrapper">
                                    <img src="../uploads/news/<?= $n['image'] ?>" alt="News Image">
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="item-card" style="justify-content: center; color: #999;">
                        <h3>No news or activities posted yet.</h3>
                    </div>
                <?php endif; ?>
            </div>

            <div id="tab-serv" class="content-section <?= ($active_tab == 'tab-serv') ? 'active' : '' ?>">
                <?php if($serv_list && $serv_list->num_rows > 0): ?>
                    <?php while($s = $serv_list->fetch_assoc()): ?>
                        <div class="item-card service-card">
                            <div class="service-cat"><?= htmlspecialchars($s['category'] ?? 'General') ?></div>
                            <div style="font-size: 1.8rem; font-weight: 700; color: #2c3e50; margin: 8px 0;"><?= htmlspecialchars($s['title']) ?></div>
                            <div style="font-weight: 600; color: #555; margin-bottom: 15px;">Provider: <?= htmlspecialchars($s['provider']) ?></div>
                            
                            <p style="color: #666; font-size: 16px; line-height: 1.6;"><?= nl2br(htmlspecialchars($s['description'])) ?></p>

                            <div class="info-grid">
                                <div><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> <?= htmlspecialchars($s['location'] ?: 'Not Specified') ?></div>
                                <div><i class="fas fa-phone"></i> <strong>Contact:</strong> <?= htmlspecialchars($s['contact'] ?: 'No Contact Provided') ?></div>
                                <div><i class="fas fa-clock"></i> <strong>Schedule:</strong> <?= htmlspecialchars($s['schedule'] ?: 'Contact for Details') ?></div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="item-card" style="justify-content: center; color: #999;">
                        <h3>No community services currently active.</h3>
                    </div>
                <?php endif; ?>
            </div>

        </main>
    </div>

<script>
/**
 * TAB SWITCHING LOGIC
 * @param {string} id - The ID of the tab content to show.
 * @param {boolean} updateUrl - Whether to update the browser address bar.
 */
function openTab(id, updateUrl = true) {
    // Hide all sections and remove active class from buttons
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
    });
    
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Show selected section
    const targetSection = document.getElementById(id);
    if(targetSection) {
        targetSection.classList.add('active');
        
        // Find and highlight the correct button
        let btnId = 'btn-ann';
        if(id === 'tab-serv') btnId = 'btn-serv';
        if(id === 'tab-news') btnId = 'btn-news';
        document.getElementById(btnId).classList.add('active');
    }

    // Update the URL without reloading (only if requested)
    if(updateUrl) {
        let tabName = id === 'tab-serv' ? 'services' : (id === 'tab-news' ? 'news' : 'announcements');
        window.history.pushState({}, '', 'brgy_support_center?tab=' + tabName);
    }
}

/**
 * AUTO-TAB SELECTOR ON PAGE LOAD
 */
$(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab');

    // Run openTab with 'false' to avoid pushState redundancy on load
    if (activeTab === 'services') {
        openTab('tab-serv', false);
    } else if (activeTab === 'news') {
        openTab('tab-news', false);
    } else if (activeTab === 'announcements') {
        openTab('tab-ann', false);
    }
});
</script>

</body>
</html>