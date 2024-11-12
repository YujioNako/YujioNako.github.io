<?php
// 设置默认时区
date_default_timezone_set('Asia/Shanghai');

$servername = "proivan-mssql.mysql.database.azure.com";
$username = "yujionako";
//$servername = "localhost";
//$username = "root";
$password = "Ldc123456";
$dbname = "AmIOnline";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT device_id, status, cpu_usage, ram_usage, last_update FROM device_status";
$result = $conn->query($sql);

$isAnyDeviceOnline = false;
$current_time = time();
$devices = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // 从数据库获取的 UTC 时间
        $last_update = $row['last_update'];
        
        // 创建 DateTime 对象并设置为 UTC
        $date = new DateTime($last_update, new DateTimeZone('UTC'));
        
        // 将时间转换为服务器的当地时区
        $date->setTimezone(new DateTimeZone(date_default_timezone_get()));
        
        // 获取转换后的时间戳
        $last_update_timestamp = $date->getTimestamp();
        
        // 计算时间差（以秒为单位）
        $time_diff = $current_time - $last_update_timestamp;

        // 如果时间差大于3分钟（180秒），则更新状态为offline
        if ($time_diff > 20) {
            $status = 'offline';
            $update_sql = "UPDATE device_status SET status='$status', last_update=last_update WHERE device_id='$device_id'";
            $row['status'] = $status;
            if ($conn->query($update_sql) === TRUE) {
                //echo "Device ID $device_id status updated to offline.\n";
            } else {
                echo "Error updating record for device ID $device_id: " . $conn->error . "\n";
            }
        }
        
        $devices[] = $row;
        if ($row['status'] === 'online') {
            $isAnyDeviceOnline = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>钰中在吗?</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .status {
            text-align: center;
            font-size: 1.4em;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .status-online {
            color: green;
            border: 2px solid green;
        }
        .status-offline {
            color: red;
            border: 2px solid red;
        }
        .tips {
            text-align: center;
            color: grey;
            font-size: 0.9em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 1em;
        }
        @media (max-width:620px) {
            table {
                font-size: 0.75em;
            }
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>钰中在吗?</h1>
        <div class="status <?php echo $isAnyDeviceOnline ? 'status-online' : 'status-offline'; ?>">
            <?php echo $isAnyDeviceOnline ? '钰中已上线' : '钰中已下线'; ?>
        </div>
        <div class="tips"><?php echo $isAnyDeviceOnline ? '现在通过哔哩哔哩、邮箱等方式大概率可以联系到钰中' : '钰中正在摸鱼……'; ?></div>
        <table>
            <tr>
                <th>设备名</th>
                <th>状态</th>
                <th>CPU %</th>
                <th>RAM %</th>
                <th>最后在线信号</th>
            </tr>
            <?php foreach ($devices as $device): ?>
                <tr>
                    <td>
                    <?php
                    $device_id = $device['device_id'];
                    
                    // 查询device_name
                    $sql = "SELECT device_name FROM allowed_devices WHERE device_id = '$device_id'";
                    $result = $conn->query($sql);
                    $device_name = $result->fetch_assoc()['device_name'];
                    
                    if ($device_name) {
                        echo $device_name;
                    } else {
                        echo "未命名设备";
                    }
                    ?>
                    </td>
                    <td class="<?php echo $device['status'] === 'online' ? 'status-online' : 'status-offline'; ?>">
                        <?php echo htmlspecialchars(ucfirst($device['status'])); ?>
                    </td>
                    <td><?php echo htmlspecialchars($device['cpu_usage']); ?></td>
                    <td><?php echo htmlspecialchars($device['ram_usage']); ?></td>
                    <td><?php echo htmlspecialchars(DateTime::createFromFormat('y-m-d H:i:s', substr($device['last_update'], 2), new DateTimeZone('UTC'))->setTimezone(new DateTimeZone(date_default_timezone_get()))->format('y-m-d H:i:s')); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php 
            // 关闭连接
            $conn->close();
        ?>
    </div>
</body>
</html>
