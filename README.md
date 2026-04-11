# Canonical Text Trees 古籍基準正文樹

在處理杜甫詩的時候，我看到了<a href="https://github.com/wingmingchan64/Dufu-Analysis/blob/main/docs/architecture/canonical_text_tree.md">基準正文樹</a>的巨大潛力。這裏搜集了三類文檔：

- 從網上搜集來的、未經校對的詩、詞、文、小說
- 從這些古籍轉換過來的基準正文樹
- 轉換用的 PHP、Python 程式（Python 程式多是 ChatGPT 提供的）

步驟：

- 按一定格式，整理文本（存於 .txt 文檔中），修改錯字、簡體字（只用正體字）
- 以 PHP 程式，把文本文字轉換成基準正文樹

用途：

- 結合不同的後設資料集，可以生成不同版本、注本、評本
- 幷列不同的版本
- <a href="https://github.com/wingmingchan64/Dufu-Analysis/blob/main/docs/workflow/pipeline.md">Processing Pipeline</a>

已生成:

- <a href="https://github.com/wingmingchan64/Dufu-Analysis/tree/main/schemas/json/base_text">杜甫</a>
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/tree/main/全唐詩/trees">白居易（卷424-436）</a>
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/tree/main/紅樓夢/trees">《紅樓夢》凡例、第一至第三回</a>
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/tree/main/詩經/trees">《詩經》</a>
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/blob/main/論語/trees/01.json">《論語·學而第一》</a>
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/tree/main/老子">《老子》</a>
- <a href="https://github.com/wingmingchan64/CanonicalTextTrees/blob/main/莊子/trees/01.json">《莊子·逍遙遊》</a>

