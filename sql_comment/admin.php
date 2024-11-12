<meta charset="utf-8">
<script>
    function updateButton() {
        var textbox1 = document.getElementById('id').value;
        var textbox2 = document.getElementById('reply').value;
        var button = document.getElementById('submit');

        if (textbox1 !== '' && textbox2 === '') {
            button.value = '删除';
            button.disabled = false;
        } else if (textbox1 !== '' && textbox2 !== '') {
            button.value = '回复';
            button.disabled = false;
        } else {
            button.value = '回复/删除';
            button.disabled = true;
        }
    }
</script>

<?php
session_start();
if(!isset($_SESSION['comment_auth'])||$_SESSION['comment_auth']!==true){
    // 设置有效的用户名和密码
    $validUsername = 'yujionako';
    $validPassword = 'Ldc020321';
    
    // 检查表单提交

    $username = $_POST['username'];
    $password = $_POST['password'];

    // 验证用户名和密码
    if ($username === $validUsername && $password === $validPassword) {
        // 设置会话变量表示已经通过验证
        $_SESSION['comment_auth'] = true;

        // 重定向到受限页面
        echo "
        <h1>评论操作</h1>
        <form action='' method='post'><table class='mdui-table'>
            <table>
                <tbody>
                    <tr>
                        <th>
                            <label class='mdui-textfield-label'>ID</label>
                            <input type='text' class='mdui-textfield-input' id='id' name='id' placeholder='请输入id' required='required' maxlength='25' style='width:98%;' oninput='updateButton()'><br>
                            <label class='mdui-textfield-label'>回复</label>
                            <input type='text' class='mdui-textfield-input' id='reply' name='reply' placeholder='不填则使用删除功能' maxlength='200' style='width:98%;' oninput='updateButton()'><br>
                            <center><input class='mdui-btn mdui-ripple mdui-btn-raised mdui-btn-dense mdui-color-theme' id='submit' type='submit' id ='submitButton' value='回复/删除' onclick='' disabled></center>
                        </th>
                    </tr>
                </tbody>
            </table>
        </form>
        ";
    } else {
        // 验证失败，显示错误消息
        echo '
    <h1>登录</h1>
    <form method="POST" action="">
        <label for="username">用户名:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">密码:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="登录">
    </form>
        ';
    }
}
else{
    echo "
    <h1>评论操作</h1>
    <form action='' method='post'><table class='mdui-table'>
        <table>
            <tbody>
                <tr>
                    <th>
                        <label class='mdui-textfield-label'>ID</label>
                        <input type='text' class='mdui-textfield-input' id='id' name='id' placeholder='请输入id' required='required' maxlength='25' style='width:98%;' oninput='updateButton()'><br>
                        <label class='mdui-textfield-label'>回复</label>
                        <input type='text' class='mdui-textfield-input' id='reply' name='reply' placeholder='不填则使用删除功能' maxlength='200' style='width:98%;' oninput='updateButton()'><br>
                        <center><input class='mdui-btn mdui-ripple mdui-btn-raised mdui-btn-dense mdui-color-theme' id='submit' type='submit' id ='submitButton' value='回复/删除' onclick='' disabled></center>
                    </th>
                </tr>
            </tbody>
        </table>
    </form>
    ";
}


if(!isset($_SESSION['comment_auth'])||$_SESSION['comment_auth']!==true) exit('未登录，请登陆后再操作！');
if(!isset($_POST["id"])) exit('请在输入后提交');
// 连接数据库
$servername = "proivan-mssql.mysql.database.azure.com";
$username = "yujionako";
$password = "Ldc123456";
$dbname = "messages";

$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接是否成功
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

if($_POST["id"]!=''&&$_POST["reply"]!=''){
    // 获取管理员提交的回复
    $id = $_POST["id"];
    $reply = $_POST["reply"];
    
    // 更新评论记录中的回复字段
    $sql = "UPDATE comments SET reply='$reply', updated_at=NOW() WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "回复已提交到评论id：".$id;
    } else {
        echo "回复失败: " . $sql . "<br>" . $conn->error;
    }
    
    // 关闭数据库连接
    $conn->close();
}
else{
    $id = $_POST["id"];
    $sql = "DELETE FROM comments WHERE id = $id";
    // 执行查询
    if ($conn->query($sql) === TRUE) {
        echo "成功删除一行数据，id：".$id;
    } else {
        echo "删除数据失败: " . $sql . "<br>" . $conn->error;
    }
}

?>