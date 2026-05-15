<?php include_once 'greendefender.php'; ?>

<?php
// 記錄所有頁面的訪問
include_once 'db.php';
recordVisit($conn);

// 只有首頁顯示總訪問人次
$show_visits = (basename($_SERVER['PHP_SELF']) === 'index.php');
if ($show_visits) {
    $total_visits = getTotalVisits($conn);
}
$conn->close();
?>

<footer class="footer">
    <?php if ($show_visits): ?>
        <div style="width: 100%; text-align: center; margin-bottom: 15px; font-size: 16px; color: var(--text-light);">
            🌐 網站總訪問人次：<?php echo number_format($total_visits); ?>
        </div>
    <?php endif; ?>
    
    <!-- 完美居中版 - 占满整行，在所有设备上都居中 -->
    <div style="width: 100%; text-align: center; margin: 0; padding: 0;">
        © 2026 SDG12 永續生活家學習平台
    </div>
</footer>

<script src="assets/js/modal.js"></script>
