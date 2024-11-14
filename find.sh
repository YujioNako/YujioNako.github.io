#!/bin/bash

# 设置网站根目录和域名
root_dir="/www/wwwroot/pro-ivan.cn/"
domain="http://pro-ivan.com/"

# 创建 sitemap.xml 文件
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" > sitemap.xml
echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">" >> sitemap.xml

# 遍历所有 HTML 和 PHP 文件
find "$root_dir" \( -name "*.html" -o -name "*.php" \) | while read file; do
  # 获取相对路径并转换为 URL
  url="${file#$root_dir}"
  echo "  <url>" >> sitemap.xml
  echo "    <loc>$domain$url</loc>" >> sitemap.xml
  echo "  </url>" >> sitemap.xml
done

echo "</urlset>" >> sitemap.xml

echo "Sitemap generated at sitemap.xml"
