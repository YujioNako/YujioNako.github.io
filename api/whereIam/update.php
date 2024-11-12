<?php
$servername = "proivan-mssql.mysql.database.azure.com";
$username = "yujionako";
$password = "Ldc123456";
$dbname = "whereIam";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

// 获取POST数据
if(!$_POST['longitude']||!$_POST['latitude']||!$_POST['token']) {
    if(!$_POST['token']) {
        die("Please take your token");
    }
    die("Please POST");
}
$longitude = round($_POST['longitude'],6);
$latitude = round($_POST['latitude'],6);
$token = $_POST['token'];

if ($token!=='yujionako@Ldc020321') {
    die('Wrong token');
}

// 准备SQL语句
$sql = "INSERT INTO location (longitude, latitude, time) VALUES ('$longitude', '$latitude', NOW())";

// 执行SQL语句
if ($conn->query($sql) === TRUE) {
    echo "Recorded!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// 关闭连接
$conn->close();
?>
