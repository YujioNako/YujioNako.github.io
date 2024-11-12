<head>
    <meta charset="utf-8">
    <title>comment board</title>
    <style>
    .comments-container {
      margin: 20px;
    }
    
    .comment {
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 10px;
      margin-bottom: 10px;
    }
    
    .comment-header {
      display: flex;
      align-items: center;
      margin-bottom: 5px;
    }
    
    .comment-id {
      font-weight: bold;
      margin-right: 5px;
    }
    
    .comment-name {
      font-weight: bold;
      margin-right: 5px;
    }
    
    .comment-time {
      color: #888;
    }
    
    .comment-content {
      margin-bottom: 10px;
    }
    
    .admin-comment {
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 10px;
      margin-top: 10px;
      background-color: #eeeeee;
    }
    
    .admin-comment-label {
      font-weight: bold;
      margin-right: 5px;
    }
    
    .admin-comment-name {
      font-weight: bold;
      margin-right: 5px;
    }
    
    .admin-comment-time {
      color: #888;
    }
    
    .admin-comment-content {
      margin-top: 5px;
    }

    ::-webkit-scrollbar {
        width: 0.5em;
        background-color: #ddd;
    }
    
    ::-webkit-scrollbar-thumb {
        background-color: #aaa;
    }
    
    /* 添加更多样式以适应您的设计需求 */


    </style>
</head>
<body>
<?php
//error_reporting(0);
// 连接数据库
$servername = "proivan-mssql.mysql.database.azure.com";
$username = "yujionako";
$password = "Ldc123456";
$dbname = "messages";

$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

// 检查连接是否成功
if (!$conn) {
    die("连接失败：" . mysqli_connect_error());
}

// 从数据库中读取评论数据
$sql = "SELECT * FROM comments ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

$referer = $_SERVER['HTTP_REFERER'];
$isChinese = strpos($referer, 'en') === false;

// 在表格中显示评论数据
if (mysqli_num_rows($result) > 0) {
echo "<div class='comments-container'>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='comment'>";
    echo "<div class='comment-header'>";
    echo "<span class='comment-id'>#" . $row["id"] . "</span>";
    echo "<span class='comment-name'>" . $row["name"] . "</span>";
    echo "<span class='comment-time'>" . (($lastColonPos = strrpos($row["created_at"], ':')) !== false ? substr($row["created_at"], 0, $lastColonPos) : $row["created_at"]) . " (". $row["location"]  . ")</span>";
    echo "</div>";
    echo "<div class='comment-content'>" . $row["comment"] . "</div>";
    
    // 如果有管理员留言，显示管理员留言及留言时间
    if (!empty($row["reply"])) {
        echo "<div class='admin-comment'>";
        echo "<span class='admin-comment-label'>𝗟</span>";
        echo "<span class='admin-comment-name'>(Admin)</span>";
        echo "<span class='admin-comment-time'>" . (($lastColonPos = strrpos($row["updated_at"], ':')) !== false ? substr($row["updated_at"], 0, $lastColonPos) : $row["updated_at"]) . "</span>";
        echo "<div class='admin-comment-content'>" . $row["reply"] . "</div>";
        echo "</div>";
    }
    
    echo "</div>";
}
echo "<hr style='color:#bbb;'><center style='color:#bbb'>没有更多内容了~</center></div>";

} else {
    echo "No message now. | 暂无评论。";
}

// 关闭数据库连接
mysqli_close($conn);
?>
<!--
<div><h3 id='留言板'>留言板</h3><div class='mdui-table-fluid mdui-table th' style='margin-left:1%;width:98%;'><br><form action='./comment.php' method='post'><table class='mdui-table'><tbody><tr><th><label class='mdui-textfield-label'>昵称</label><input type='text' class='mdui-textfield-input' name='name' placeholder='请输入昵称(小于25字)' required='required' maxlength='25' style='width:98%;'><br><label class='mdui-textfield-label'>评论</label><input type='text' class='mdui-textfield-input' name='comment' placeholder='要讲文明哟~(小于200字)' required='required' maxlength='200' style='width:98%;'><br><center><input class='mdui-btn mdui-ripple mdui-btn-raised mdui-btn-dense mdui-color-theme' type='submit' id ='submitButton' value='发送' onclick=''></center></th></tr></tbody></table></form>
-->
</body>