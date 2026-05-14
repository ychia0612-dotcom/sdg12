<?php
session_start(); // 啟動會話以保存用戶暱稱

// 處理暱稱提交
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nickname'])) {
    $nickname = trim($_POST['nickname']);
    if (!empty($nickname)) {
        $_SESSION['quiz_nickname'] = htmlspecialchars($nickname);
        // 防止表單重複提交
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// 檢查是否已有暱稱
$has_nickname = isset($_SESSION['quiz_nickname']) && !empty($_SESSION['quiz_nickname']);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG12 知識測驗 - 永續生活家學習平台</title>
    <style>
        /* 暱稱輸入模態框樣式 */
        .nickname-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        
        .modal-content h2 {
            color: #2e7d32;
            margin-bottom: 20px;
            font-size: 24px;
        }
        
        .modal-content p {
            color: #555;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        
        .nickname-input {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        
        .nickname-input:focus {
            outline: none;
            border-color: #4caf50;
        }
        
        .start-btn {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }
        
        .start-btn:hover {
            background-color: #388e3c;
        }
        
        /* 測驗內容樣式 (隱藏直到輸入暱稱) */
        .quiz-content {
            display: <?php echo $has_nickname ? 'block' : 'none'; ?>;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .welcome-message {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #e8f5e9;
            border-radius: 10px;
            color: #2e7d32;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <!-- 暱稱輸入模態框 -->
    <?php if (!$has_nickname): ?>
    <div class="nickname-modal" id="nicknameModal">
        <div class="modal-content">
            <h2>🌱 SDG12 知識挑戰賽</h2>
            <p>歡迎來到永續生活家知識測驗！<br>請輸入你的暱稱，開始你的綠色挑戰之旅吧！</p>
            <form method="POST" id="nicknameForm">
                <input type="text" class="nickname-input" name="nickname" id="nicknameInput" 
                       placeholder="請輸入你的暱稱" required autocomplete="off">
                <button type="submit" class="start-btn">開始挑戰 🚀</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- 測驗主要內容 -->
    <div class="quiz-content">
        <!-- 歡迎訊息 (顯示用戶暱稱) -->
        <?php if ($has_nickname): ?>
        <div class="welcome-message">
            嗨，<strong><?php echo $_SESSION['quiz_nickname']; ?></strong>！準備好接受SDG12永續消費與生產的知識挑戰了嗎？
        </div>
        <?php endif; ?>

        <!-- 以下是你原有的測驗內容 -->
        <!-- ====================================== -->
        <!-- 請在這裡保留你原本的測驗題目和邏輯代碼 -->
        <!-- ====================================== -->
        <div style="text-align: center; padding: 50px 0;">
            <h3>測驗內容區域</h3>
            <p>請將你原本的測驗題目和相關代碼替換此處內容</p>
        </div>
    </div>

    <!-- 網站頁腳 (與你提供的程式碼完全一致) -->
    <?php include_once 'greendefender.php'; ?>

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

    <!-- 暱稱輸入驗證JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('nicknameForm');
            const input = document.getElementById('nicknameInput');
            
            if (form && input) {
                form.addEventListener('submit', function(e) {
                    if (input.value.trim() === '') {
                        e.preventDefault();
                        alert('請輸入你的暱稱！');
                        input.focus();
                    }
                });
                
                // 自動聚焦到輸入框
                input.focus();
            }
        });
    </script>
</body>
</html>
