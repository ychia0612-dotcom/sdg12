<?php include_once 'greendefender.php'; ?>

<!-- 網站頁腳 -->
<?php
// 只有在首頁才顯示訪問人次
if (basename($_SERVER['PHP_SELF']) === 'index.php') {
    include_once 'db.php';
    recordVisit($conn); // 記錄本次訪問
    $total_visits = getTotalVisits($conn);
    $conn->close();
?>
<div style="text-align:center; margin:10px 0;">
    🌐 網站總訪問人次：<?php echo number_format($total_visits); ?>
</div>
<?php } ?>

<div style="text-align:center; margin:10px 0;">
    © 2026 SDG12 永續生活家學習平台
</div>

<script src="assets/js/modal.js"></script>
</body>
</html>
