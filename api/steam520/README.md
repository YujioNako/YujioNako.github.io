<h1>使用方法</h1>

下面的地址无需访问 GitHub 即可获取到最新的 hosts 内容：<br>

· 文件：<u>https://pro-ivan.com/api/steam520/hosts</u><br>

<h3>1.1 手动方式</h3>

<h5>1.1.1 复制下面的内容</h5>

<pre>
# Steam520 Host Start
23.221.227.5                  cdn.steamcommunity.com

# Update time: 2024-11-07T16:06:12+08:00
# Update url: https://pro-ivan.com/api/steam520/hosts
# Star author: https://github.com/521xueweihan/GitHub520
# This is a back-up from Pro-ivan.com
# Original author all rights reserve
# Steam520 Host End

</pre>

<br>该内容会自动定时更新， 数据更新时间：2024-11-07T16:06:12+08:00<br>

<h5>1.1.2 修改 hosts 文件</h5>

hosts 文件在每个系统的位置不一，详情如下：<br>
· Windows 系统：<u>C:\Windows\System32\drivers\etc\hosts</u><br>
· Linux 系统：<u>/etc/hosts</u><br>
· Mac（苹果电脑）系统：<u>/etc/hosts</u><br>
· Android（安卓）系统：<u>/system/etc/hosts</u><br>
· iPhone（iOS）系统：<u>/etc/hosts</u><br>

修改方法，把第一步的内容复制到文本末尾：<br>

1.Windows 使用记事本。<br>
2.Linux、Mac 使用 Root 权限：<u>sudo vi /etc/hosts</u>。<br>
3.iPhone、iPad 须越狱、Android 必须要 root。<br>

<h5>1.1.3 激活生效</h5>
大部分情况下是直接生效，如未生效可尝试下面的办法，刷新 DNS：<br>

1.Windows：在 CMD 窗口输入：<u>ipconfig /flushdns</u><br>

2.Linux 命令：<u>sudo nscd restart</u>，如报错则须安装：<u>sudo apt install nscd</u> 或 <u>sudo /etc/init.d/nscd restart</u><br>

3.Mac 命令：<u>sudo killall -HUP mDNSResponder</u><br>

<b>Tips：</b> 上述方法无效可以尝试重启机器。<br>

<h3>1.2 自动方式（SwitchHosts）</h3>

<b>Tip</b>：推荐 <a href="https://github.com/oldj/SwitchHosts">SwitchHosts</a> 工具管理 hosts<br>

以 SwitchHosts 为例，看一下怎么使用的，配置参考下面：<br>

· Title: 随意<br>

· Type: <u>Remote</u><br>

· URL: <u>https://pro-ivan.com/api/steam520/hosts</u><br>

· Auto Refresh: 最好选 <u>1 hour</u><br>

如图：<br>

<img src="./img/switch-hosts.png" width=75%><br><br>

这样每次 hosts 有更新都能及时进行更新，免去手动更新。<br>

<h3>1.3 一行命令 (适用于类 Unix 系统)</h3>

<u>sed -i "/# Steam520 Host Start/Q" /etc/hosts && curl https://pro-ivan.com/api/steam520/hosts >> /etc/hosts</u><br>

将上面的命令添加到 cron，可定时执行。使用前确保 steam520 内容在该文件最后部分。<br>

<h3>1.4 AdGuard 用户（自动方式）</h3>

在 <b>过滤器>DNS 封锁清单>添加阻止列表>添加一个自定义列表</b>，配置如下：<br>

· 名称：随意<br>

· URL：<u>https://pro-ivan.com/api/steam520/hosts</u>（和上面 SwitchHosts 使用的一样）<br>

如图：<br>

<img src="./img/AdGuard-rules.png" width=75%><br><br>

更新间隔在 <b>设置 > 常规设置 > 过滤器更新间隔（设置一小时一次即可）</b>，记得勾选上 <b>使用过滤器和 Hosts 文件以拦截指定域名</b><br>

<img src="./img/AdGuard-rules2.png" width=75%><br><br>

<b>Tip</b>：不要添加在 <b>DNS 允许清单</b> 内，只能添加在 <b>DNS 封锁清单</b> 才管用。 另外，AdGuard for Mac、AdGuard for Windows、AdGuard for Android、AdGuard for IOS 等等 <b>AdGuard 家族软件</b> 添加方法均类似。<br>



<h2>声明</h2>
<a rel="license" href="https://creativecommons.org/licenses/by-nc-nd/4.0/deed.zh"><img alt="知识共享许可协议" style="border-width: 0" src="https://licensebuttons.net/l/by-nc-nd/4.0/88x31.png"></a><br>本作品采用 <a rel="license" href="https://creativecommons.org/licenses/by-nc-nd/4.0/deed.zh">署名-非商业性使用-禁止演绎 4.0 国际</a> 进行许可。<br>最终解释权归原作者<a href="https://github.com/521xueweihan/">削微寒</a>所有。