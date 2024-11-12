<?php
session_start();
error_reporting(0);
require 'email.class.php';
require 'ip2region/Ip2Region.php';
echo "<br>";

if (strpos($_POST["comment"], "密码") !== false) {
    exit('<i class="mdui-icon material-icons">info</i> 管理密码为：yujionako');
}

$limit = 60; // 间隔阈值
$currentTime = time(); // 当前时间戳

if (isset($_SESSION['lastAccessTime'])) {
    $lastAccessTime = $_SESSION['lastAccessTime'];
    if ($currentTime - $lastAccessTime < $limit) {
        exit('<i class="mdui-icon material-icons">warning</i> 访问频率过高，请等待2分钟后再试！');
    }
}

// 更新最后访问时间
$_SESSION['lastAccessTime'] = $currentTime;

function getIp() {
    $ip = false;

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    // 处理IPv4地址
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        return $ip;
    }

    // 如果有多个IP（通常是通过代理时），只取第一个
    $ipList = explode(',', $ip);
    foreach ($ipList as $ip) {
        $ip = trim($ip);
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return $ip;
        }
    }
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

$ip = getIp();

// 根据IP获取城市、网络运营商等信息
if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
    $ip2region = new Ip2Region();
    $info = $ip2region->btreeSearch($ip);
    $region = $info['region'];
} else {
    $region = "未知的ipv6地址";
}

date_default_timezone_set("Asia/Shanghai");
$title = $_POST["name"];
$gain = $_POST["comment"];
$contact = $_POST["contact"];
$subtime = date("Y-m-d H:i:s");
$fileName = './comment.txt';
$location = explode('|', $region)[2];

$content = "User_Name " . $title . PHP_EOL . " Comment  " . $gain . PHP_EOL . "  Time.   " . $subtime . "(UTC+8) 发自" . $location . PHP_EOL . "---------" . PHP_EOL;

if (empty($gain) || empty($title)) {
    exit('<i class="mdui-icon material-icons">warning</i> 评论失败！表单中未包含昵称或留言内容！');
} else {
    function strPosFuck($content) {
        $fuck = file_get_contents('bannedword.txt');
        $content = trim($content);
        $fuckArr = explode("\n", $fuck);
        for ($i = 0; $i < count($fuckArr); $i++) {
            if ($fuckArr[$i] == "") {
                continue;
            }
            if (strpos($content, trim($fuckArr[$i])) !== false) {
                return $fuckArr[$i];
            }
        }
        return false;
    }

    $key = strPosFuck($content);
    if ($key) {
        exit('<i class="mdui-icon material-icons">warning</i> 昵称或评论中存在不当词汇：' . $key);
    } else {
        $file = fopen($fileName, 'r');
        $content_txt = fread($file, filesize($fileName));
        $contents = $content . $content_txt;
        fclose($file);
        $file = fopen($fileName, 'w');
        fwrite($file, $contents);
        fclose($file);

        // 连接数据库
        $servername = "proivan-mssql.mysql.database.azure.com";
        $username = "yujionako";
        $password = "Ldc123456";
        $dbname = "messages";

        $conn = new mysqli($servername, $username, $password, $dbname);
        mysqli_set_charset($conn, "utf8");

        // 检查连接是否成功
        if ($conn->connect_error) {
            die('<i class="mdui-icon material-icons">error</i> 连接失败: ' . $conn->connect_error);
        }

        // 将评论插入到数据库中
        $sql = "INSERT INTO comments (name, comment, location) VALUES ('$title', '$gain', '$location')";

        if ($conn->query($sql) === TRUE) {
            echo '<i class="mdui-icon material-icons">info</i> 评论已提交到sql<br>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // 关闭数据库连接
        $conn->close();

        function sendmailto($mailto, $mailsub, $mailbd) {
            $smtpserver = "ssl://smtp.ym.163.com";
            $smtpserverport = 465;
            $smtpusermail = "no-reply@pro-ivan.cn";
            $smtpemailto = $mailto;
            $smtpuser = "no-reply@pro-ivan.cn";
            $smtppass = "Ldc123456";
            $mailsubject = "=?UTF-8?B?" . base64_encode($mailsub) . "?=";
            $mailbody = $mailbd;
            $mailtype = "HTML";

            $smtp = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
            $smtp->debug = false;
            $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
        }

        $mailto = '2531667489@qq.com';
        $subject = "新留言通报(主版)";
        $body = "<b><font size=2.5>User_Name " . $title . " (Contact " . $contact . ")</font></b><br><br><b>Comment</b><font size=2 style='margin-left:10px;'><pre>└" . $gain . "</pre></font><br><br><font size=1.5 color=#808080>  Time.   " . $subtime . "(UTC+8)" . "<br>from " . $location . "(" . $ip . ")<br>In page " . $_SERVER["HTTP_REFERER"] . "<br>end.</font>";
        sendmailto($mailto, $subject, $body);

        exit('<i class="mdui-icon material-icons">done</i> 评论成功!!');
    }
}
?>
