<?php
// 设置默认时区
date_default_timezone_set('Asia/Shanghai');

$servername = "proivan-mssql.mysql.database.azure.com";
$username = "yujionako";
$password = "Ldc123456";
$dbname = "AmIOnline";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $device_id = $_POST['device_id'];
    $status = $_POST['status'];
    $cpu_usage = $_POST['cpu_usage'];
    $ram_usage = $_POST['ram_usage'];

    // 检查设备是否被允许
    $check_device_sql = "SELECT COUNT(*) as count FROM allowed_devices WHERE device_id='$device_id'";
    $result = $conn->query($check_device_sql);
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        if ($status === 'online' || $status === 'offline') {
        $sql = "INSERT INTO device_status (device_id, status, cpu_usage, ram_usage, last_update) 
                VALUES ('$device_id', '$status', '$cpu_usage', '$ram_usage', NOW()) 
                ON DUPLICATE KEY UPDATE status='$status', cpu_usage='$cpu_usage', ram_usage='$ram_usage', last_update=NOW();";

            if ($conn->query($sql) === TRUE) {
                echo "Status updated successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Wrong status: Invalid status";
        }
    } else {
        echo "Wrong device_id: Unauthorized device";
    }
}

$conn->close();
?>
