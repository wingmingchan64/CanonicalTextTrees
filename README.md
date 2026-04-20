# Canonical Text Trees 古籍基準正文樹

在處理杜甫詩的時候，我看到了<a href="https://github.com/wingmingchan64/Dufu-Analysis/blob/main/docs/architecture/canonical_text_tree.md">基準正文樹</a>的巨大潛力。這裏收集了五類文檔：

- 從網上搜集來的、未經校對的詩、詞、文、小說
- 從這些古籍轉換過來的基準正文樹
- 轉換用的 PHP、Python 程式（Python 程式多是 ChatGPT 提供的）
- 以基準正文樹爲基礎而生成的各種正文、路徑/坐標對照表
- 爲<a href="https://github.com/wingmingchan64/Dufu-Analysis/blob/main/docs/text_addressing/overview.md">文本定位</a>而編寫的程式

---

## 目的

展示如何從建立基準正文文檔，到生成基準正文樹，以及各種的 mapping 文檔，最後如何利用這些生成的文檔：
- 在樹中準確地爲文字片段定位（text search）
- 以路徑提取文字片段（text retrieval）

---

## 用途

- 單憑一棵基準正文樹，就能以不同面貌（格式），呈現同一個文本（<a href="https://github.com/wingmingchan64/CanonicalTextTrees/blob/main/論語/views/02.md">《論語·爲政第二》</a>）
- 結合不同的後設資料集，可以生成不同版本、注本、評本
- 幷列不同的版本
- <a href="https://github.com/wingmingchan64/Dufu-Analysis/blob/main/docs/workflow/pipeline.md">Processing Pipeline</a>
- <a href="https://github.com/wingmingchan64/Dufu-Analysis/blob/main/docs/text_addressing/overview.md">文本定位</a>
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/blob/main/從基準文本到正文定位.md">從基準文本到正文定位</a>

---

## 進度

以下文獻支持全文搜索：

- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/tree/main/全唐詩/trees/">《全唐詩》杜甫</a>
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/tree/main/詩經/trees">《詩經》</a>
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/blob/main/論語/trees/">《論語》</a> （校對參考書：《論語注疏》，北京大學出版社2000年12月；楊伯峻《論語譯注》，中華書局1980年）
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/blob/main/孟子/trees/">《孟子》</a> （校對參考書：《孟子注疏》，北京大學出版社2000年12月；楊伯峻《孟子譯注》，中華書局1960年）
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/tree/main/老子/trees">《老子》</a> （校對參考書：《老子》，王弼注，上海中華書局據華亭張氏本校刊）

正在進行中：

- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/tree/main/全唐詩/trees">《全唐詩》白居易（卷424-439）</a>
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/tree/main/紅樓夢/trees">《紅樓夢》凡例、第一至第三回</a>

- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/blob/main/莊子/trees/01.json">《莊子·逍遙遊》</a>