import requests
import re
from datetime import datetime
import time


ServerName = 'MyVPN'


# 摘取字符串中的所有IP
def extract_ip_addresses(text):
    ip_pattern = r'\b(?:\d{1,3}\.){3}\d{1,3}(?::\d{1,5})?\b'  # IP 地址的正则表达式模式
    ip_addresses = re.findall(ip_pattern, text)
    return ip_addresses


# 测试连接
def website_connection_test(url):
    try:
        response = requests.get(url, timeout=10)
        if response.status_code == 200:
            print("Connection to the website is successful!")
            return True
        else:
            print("Connection to the website failed with status code:", response.status_code)
            return False
    except requests.exceptions.RequestException as e:
        print("Connection to the website failed:", str(e))
        return False


# 获取IP地址列表
def get_ip_addresses():
    url = 'http://proxypool.pro-ivan.com/all/?type=https'  # 替换为实际的API地址
    response = requests.get(url)
    if response.status_code == 200:
        ip_addresses = response.json()
        return ip_addresses
    else:
        print('Failed to fetch IP addresses from the API.')
        return []

while True:
    try:
        # 获取IP地址列表
        ip_addresses = get_ip_addresses()
        proxies = ''
        proxy_groups = ''
        index = 0
        for ip in ip_addresses:
            print('  - {"name": "' + str(index) + '#' + ip["region"].replace(' ', '_') + '", "type": "http", "server": "' + ip["proxy"].split(':')[0] + '", "port":' + ip["proxy"].split(':')[1] + ', "skip-cert-verify": true}')
            proxy_groups += "    - '" + str(index) + '#' + ip["region"].replace(' ', '_') + "'\n"
            proxies += '  - {"name": "' + str(index) + '#' + ip["region"].replace(' ', '_') + '", "type": "http", "server": "' + ip["proxy"].split(':')[0] + '", "port":' + ip["proxy"].split(':')[1] + ', "skip-cert-verify": true}\n'
            index += 1
        
        
        with open('test.yaml', 'r', encoding='utf-8') as file:
            content = file.read()
        
        filled_content = content.replace('{local_time}', datetime.now().strftime("%Y-%m-%d %H:%M:%S")).replace('{proxy}', proxies).replace('{proxy_group}', proxy_groups)
        
        with open('http_proxy.yaml', 'w', encoding='utf-8') as file:
            file.write(filled_content)
        
        time.sleep(300)
    except:
        time.sleep(20)
    
