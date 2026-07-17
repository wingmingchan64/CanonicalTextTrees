import json
from bs4 import BeautifulSoup

# 模擬讀取 HTML 內容
html_content = """<h1 class="詩題">北征</h1><table><tr><td class="眉批">蘇東坡曰...</td><td class="詩文">皇帝二載秋...<span class="注釋">注釋</span></td></tr></table>"""

def parse_du_shi_jing_quan(html_data):
    soup = BeautifulSoup(html_data, 'html.parser')
    # 提取眉批、題解、詩文等資訊
    # ... (此處省略部分解析邏輯，實際使用請參考上方代碼)
    return {"title": "北征", "meipi": ["..."], "body": [{"text": "...", "annotation": {"type": "注釋", "content": "..."}}]}

# 執行解析與輸出 JSON
output_data = parse_du_shi_jing_quan(html_content)
print(json.dumps(output_data, ensure_ascii=False, indent=2))