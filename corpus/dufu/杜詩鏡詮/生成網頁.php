<?php
/*
php H:\github\CanonicalTextTrees\corpus\dufu\杜詩鏡詮\生成網頁.php
*/
/*
require_once(
	dirname( __DIR__, 3 ) . DIRECTORY_SEPARATOR .
	'Dufu-Analysis' . DIRECTORY_SEPARATOR .
	'tools' . DIRECTORY_SEPARATOR .
	"php" . DIRECTORY_SEPARATOR .
	"lib" . DIRECTORY_SEPARATOR .
	"函式.php" );
*/

$template = file_get_contents(
	dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '模板.html' );
$詩題 = "鄭駙馬宅宴洞中";
$題解 = <<<AOD
《唐書》：明皇臨晉公主下嫁鄭潛曜。朱注：按潛曜廣文博士鄭虔之姪，公作公主母《皇甫淑妃墓碑》云：甫忝鄭莊之賓客，遊貴主之園林。《長安記》：蓮花洞在神禾原，卽鄭駙馬之居，所云主家陰洞者也。
AOD;
$眉批 = <<<MOD
邵云：拗體蒼秀。<br />
<br />
結用駙馬公主並收。<br />
MOD;

$詩文 = <<<EOD
主家陰洞細煙霧。留客夏簟清琅玕。<sub class="注釋">言簟色也。</sub>春酒杯濃琥珀薄。冰漿碗碧瑪瑙寒。<sub class="注釋">浦注：琥珀是酒是杯，瑪瑙是漿是椀，以雙關見其精麗。</sub>誤疑茅堂過江麓。已入風磴霾雲端。<sub class="注釋">朱注：草堂疑過江麓，風磴窅入雲端，二句極狀洞中之陰，解者都謬。</sub>自是秦樓壓鄭谷。<sub class="旁注">如此用古亦奇。</sub><sub class="注釋">《列仙傳》：秦穆公以女弄玉妻蕭史，日於樓上吹簫作鳳鳴，鳳止其屋。一旦，夫妻皆隨鳳去。《揚子法言》：谷口鄭子眞耕於巖石之下，名震京師。</sub>
時聞雜佩聲珊珊。
EOD;

$評論 = "《杜臆》：後半乃總四句作開合。上二句幾杳不知所之矣，迨佩響遙傳，始知身在主家也。";

$template = str_replace( '〘詩題〙', $詩題, $template );
$template = str_replace( '〘題解〙', $題解, $template );
$template = str_replace( '〘眉批〙', $眉批, $template );
$template = str_replace( '〘詩文〙', $詩文, $template );
$template = str_replace( '〘評論〙', $評論, $template );

file_put_contents( 
	dirname( __FILE__ ) . DIRECTORY_SEPARATOR .
	'views' . DIRECTORY_SEPARATOR .
	'0023.html', $template );
?>