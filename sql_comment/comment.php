<?php
if(!$_POST["name"]||!$_POST["comment"]) {
    die("Parameter missing");
}

// 连接数据库
$servername = "proivan-mssql.mysql.database.azure.com";
$username = "yujionako";
$password = "Ldc123456";
$dbname = "messages";

$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

// 检查连接是否成功
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 获取用户提交的评论
$name = $_POST["name"];
$comment = $_POST["comment"];

// 将评论插入到数据库中
$sql = "INSERT INTO comments (name, comment) VALUES ('$name', '$comment')";

if ($conn->query($sql) === TRUE) {
    echo "评论已提交";
    header("refresh:5;url=".$_SERVER['HTTP_REFERER']);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    header("refresh:5;url=".$_SERVER['HTTP_REFERER']);
}

// 关闭数据库连接
$conn->close();

?>