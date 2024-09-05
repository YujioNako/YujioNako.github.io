<?php
header('Content-Type: application/json');

// 获取GET参数中的时间范围
$startTime = isset($_GET['start']) ? $_GET['start'] : null;
$endTime = isset($_GET['end']) ? $_GET['end'] : null;

if (!$startTime || !$endTime) {
    echo json_encode(["error" => "Invalid time range"]);
    exit;
}

// 数据库连接信息
$servername = "localhost";
$username = "root";
$password = "Ldc123456";
$dbname = "whereIam";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 准备SQL查询
$sql = $conn->prepare("SELECT longitude, latitude, time FROM location WHERE time BETWEEN ? AND ? ORDER BY time ASC");
$sql->bind_param("ss", $startTime, $endTime);

// 执行查询
$sql->execute();
$result = $sql->get_result();

// 获取结果并转换为JSON格式
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// 关闭连接
$sql->close();
$conn->close();

// 返回JSON数据
echo json_encode($data);
?>
