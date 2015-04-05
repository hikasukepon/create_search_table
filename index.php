<?php
$csv = file_get_contents( '/home/hikaru.yamashita/www/fungi/project/sindan/search/k/files/草初.csv' );

//関数作成
function make_table($csv) {

	function csv_parse($file) {
		$arr = array();
		$file = explode("\n", $file);
		if(is_array($file)) {
			foreach ($file as $key => $value) {
				$arr[] = explode(",", $value);
			}
			return $arr;
		} else {
			return false;
		}
	}

	// csvをパースする
	$parse = csv_parse($csv);
	$reverse = array();
	$result = array();


	// Arrayを逆にする
	if (is_array($parse)) {
		foreach ($parse as $key => $value) {
			$reverse[] = array_reverse($value);
		}
	}

	// 項目ごとに値をまとめる
	$count = count($reverse);
	for ($i=0; $i < $count; $i++) { 
		$count_2 = count($reverse[$i]);
		for ($n=0; $n < $count_2; $n++) { 
			$result[$n][$i] = $reverse[$i][$n];
		}
	}


	// 重複削除
	foreach ($result as $kkk => $vvv) {
		$foo[] = array_unique($vvv);
	}

	// 一つのArrayにまとめる
	$kekka = array();
	$kekka['before'] = $reverse;
	$kekka['after'] = $foo;


	// retutrn
	return $kekka;
}


?>
<!DOCTYPE HTML>
<html lang="ja">
	<head>
		<!-- Title -->
		<title>検索表</title>

		<!-- meta -->
		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="description" content="検索表生成">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<meta http-equiv="Content-Script-Type" content="text/javascript">
		<meta name="author" content="Hikaru Yamashita">
		<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
		<style type="text/css">
		* {
			margin: 0;
			padding: 0;
			font-family: 'Roboto', sans-serif;
		}
		.container {
			margin:20px;
		}
		</style>
		<script type="text/javascript">
		$(function(){
			//jquery
		});
		</script>
	</head>
	<body>
		<div class="container">
			<pre><?php
			$table = make_table($csv);
			$i = 1;
			foreach ($table['before'] as $key => $value) {
				foreach ($value as $k => $val) {
					echo $i.". ".$val.".....".$k."\n";
				}
				$i++;
			}
			//print_r($table);
			?></pre>
		</div>
	</body>
</html>