<?php
// 连接到 MySQL 数据库
$servername = "proivan-mssql.mysql.database.azure.com";
$username = "yujionako";
$password = "Ldc123456";
$dbname = "elec_monitor";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// 检查连接是否成功
if (!$conn) {
    die("连接失败: " . mysqli_connect_error());
}

// 处理表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单数据
    $dromNumber = $_POST["dromNumber"];
    $dromNumber = mysqli_real_escape_string($conn, $dromNumber);
    $email = $_POST["email"];
    $email = mysqli_real_escape_string($conn, $email);
    

    // 将数据插入到数据库中
    if($email == '000@pro-ivan.cn' ){
        $sql = "DELETE FROM mytable WHERE dromNumber = ".$dromNumber;
        $email = "已清除对应邮箱";
    } else if ($email == '') {
        $sql = "SELECT DISTINCT mailto FROM mytable WHERE dromNumber = '".$dromNumber."'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            if(mysqli_num_rows($result) > 0) {
                // 如果找到结果，则显示邮箱
                $row = mysqli_fetch_assoc($result);
                $searchemail = $row['mailto'];
            } else {
                // 如果未找到结果，则显示“未绑定过邮箱”
                $searchemail = "未绑定过邮箱";
            }
        } else {
            echo "查询失败，请重试！";
        }
        echo "查询到宿舍ID".$dromNumber."的绑定对象：".$searchemail;
    } else{
        $sql = "REPLACE INTO mytable (dromNumber, mailto) VALUES ('$dromNumber', '$email')";
    }

    if ($email != '' && mysqli_query($conn, $sql)) {
        echo "数据插入成功";
        echo $dromNumber .'-->' .$email;
    } else if ($email != '') {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// 关闭数据库连接
mysqli_close($conn);
?>