<?php
header('Content-Type: application/json');

// 获取GET参数中的时间范围
$startTime = isset($_GET['start']) ? $_GET['start'] : null;
$endTime = isset($_GET['end']) ? $_GET['end'] : null;

if (!$startTime || !$endTime) {
    echo json_encode(["error" => "Invalid time range"]);
    exit;
}

//将输入时间从 UTC+8 转换为 UTC+0
try {
    $startDateTime = new DateTime($startTime, new DateTimeZone('Asia/Shanghai'));
    $startDateTime->setTimezone(new DateTimeZone('UTC'));
    $startTimeUtc = $startDateTime->format('Y-m-d H:i:s');

    $endDateTime = new DateTime($endTime, new DateTimeZone('Asia/Shanghai'));
    $endDateTime->setTimezone(new DateTimeZone('UTC'));
    $endTimeUtc = $endDateTime->format('Y-m-d H:i:s');
} catch (Exception $e) {
    echo json_encode(["error" => "Invalid date format"]);
    exit;
}

// 数据库连接信息
$servername = "proivan-mssql.mysql.database.azure.com";
$username = "yujionako";
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
    // 将数据库中的时间从 UTC+0 转换为 UTC+8
    $dbDateTime = new DateTime($row['time'], new DateTimeZone('UTC'));
    $dbDateTime->setTimezone(new DateTimeZone('Asia/Shanghai'));
    $row['time'] = $dbDateTime->format('Y-m-d H:i:s');
    $data[] = $row;
}

// 关闭连接
$sql->close();
$conn->close();

// 返回JSON数据
echo json_encode($data);
?>
