<?php
// 資料庫連線設定
$url = "mysql://root:cwEMmpToTflDcBBUAqdceFAYlmEvPFxv@yamanote.proxy.rlwy.net:38208/railway";

// 解析 URL
$db_info = parse_url($url);
$host = $db_info['host'];
$port = $db_info['port'];
$user = $db_info['user'];
$pass = $db_info['pass'];
$dbname = ltrim($db_info['path'], '/');

// 建立連線
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// 檢查連線
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

// 設定編碼
$conn->set_charset("utf8mb4");

// 建立訪問記錄表 (如果不存在)
$sql = "CREATE TABLE IF NOT EXISTS visitor_count (
    id INT AUTO_INCREMENT PRIMARY KEY,
    visit_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT,
    page_url VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

$conn->query($sql);

// 建立測驗成績表 (如果不存在)
$sql = "CREATE TABLE IF NOT EXISTS quiz_scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nickname VARCHAR(50) NOT NULL,
    mode VARCHAR(20) NOT NULL,
    score INT NOT NULL,
    total_questions INT NOT NULL,
    correct_answers INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

$conn->query($sql);

// 記錄訪問
function recordVisit($conn) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $page_url = $_SERVER['REQUEST_URI'];
    
    $stmt = $conn->prepare("INSERT INTO visitor_count (ip_address, user_agent, page_url) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $ip, $user_agent, $page_url);
    $stmt->execute();
    $stmt->close();
}

// 取得總訪問人次
function getTotalVisits($conn) {
    $result = $conn->query("SELECT COUNT(*) AS total FROM visitor_count");
    $row = $result->fetch_assoc();
    return $row['total'];
}

// 儲存測驗成績
function saveQuizScore($conn, $nickname, $mode, $score, $total, $correct) {
    $stmt = $conn->prepare("INSERT INTO quiz_scores (nickname, mode, score, total_questions, correct_answers) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiii", $nickname, $mode, $score, $total, $correct);
    $stmt->execute();
    $stmt->close();
}
?>
