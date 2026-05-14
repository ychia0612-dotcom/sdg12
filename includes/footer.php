<?php include_once 'greendefender.php'; ?>

<?php
// 記錄所有頁面的訪問
include_once 'db.php';
recordVisit($conn);

// 只有首頁顯示總訪問人次
if (basename($_SERVER['PHP_SELF']) === 'index.php') {
    $total_visits = getTotalVisits($conn);
    echo '<div style="text-align:center; margin:10px 0;">🌐 網站總訪問人次：' . number_format($total_visits) . '</div>';
}
$conn->close();
?>

<div style="text-align:center; margin:10px 0;">
    © 2026 SDG12 永續生活家學習平台
</div>

<script src="assets/js/modal.js"></script>
