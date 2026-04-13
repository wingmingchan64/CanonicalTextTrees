# Canonical Text Trees 古籍基準正文樹

在處理杜甫詩的時候，我看到了<a href="https://github.com/wingmingchan64/Dufu-Analysis/blob/main/docs/architecture/canonical_text_tree.md">基準正文樹</a>的巨大潛力。這裏搜集了五類文檔：

- 從網上搜集來的、未經校對的詩、詞、文、小說
- 從這些古籍轉換過來的基準正文樹
- 轉換用的 PHP、Python 程式（Python 程式多是 ChatGPT 提供的）
- 以基準正文樹爲基礎而生成的各種正文、路徑/坐標對照表
- 爲<a href="https://github.com/wingmingchan64/Dufu-Analysis/blob/main/docs/text_addressing/overview.md">文本定位</a>而編寫的程式

步驟：

- 按一定格式，整理文本（存於 .txt 文檔中），修改錯字、簡體字（只用正體字）
- 以 PHP 程式，把文本文字轉換成基準正文樹

用途：

- 單憑一棵基準正文樹，就能以不同面貌（格式），呈現同一個文本（<a href="https://github.com/wingmingchan64/CanonicalTextTrees/blob/main/論語/views/02.md">《論語·爲政第二》</a>）
- 結合不同的後設資料集，可以生成不同版本、注本、評本
- 幷列不同的版本
- <a href="https://github.com/wingmingchan64/Dufu-Analysis/blob/main/docs/workflow/pipeline.md">Processing Pipeline</a>
- 從書名入手，幷提供路徑，以提取書中的一個正文片段，如以「LUNYU,03,4」提取《論語》中該節點下的文字「林放問禮之本子曰大哉問禮與其奢也寧儉喪與其易也寧戚」；以「LUNYU,03,4,9,1」提取「林放問禮之本」 （<a href="https://github.com/wingmingchan64/CanonicalTextTrees/blob/main/論語/coordinates/paths.json">paths.json</a>）
- 從書名入手，幷提供一個正文片段（一句）或不相關的幾個字，以提取包含這些文字的節點的路徑，如「大宰知我乎」在《論語》中的路徑是「LUNYU,09,6,14,3」，而「大」「少」兩個字同時出現在「LUNYU,09,6,14」、「LUNYU,18,9,40」兩個節點 （<a href="https://github.com/wingmingchan64/CanonicalTextTrees/blob/main/論語/coordinates/segments_paths.json">segments_paths.json</a>、<a href="https://github.com/wingmingchan64/CanonicalTextTrees/blob/main/論語/coordinates/chars_paths.json">chars_paths.json</a>）

已生成:

- <a href="https://github.com/wingmingchan64/Dufu-Analysis/tree/main/schemas/json/base_text">杜甫</a>
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/tree/main/全唐詩/trees">白居易（卷424-436）</a>
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/tree/main/紅樓夢/trees">《紅樓夢》凡例、第一至第三回</a>
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/tree/main/詩經/trees">《詩經》</a>
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/blob/main/論語/trees/01.json">《論語》</a> （校對參考書：《論語注疏》，北京大學出版社2000年12月；楊伯峻《論語譯注》，中華書局1980年）
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/tree/main/老子">《老子》</a>
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/blob/main/莊子/trees/01.json">《莊子·逍遙遊》</a>