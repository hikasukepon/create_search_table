<meta charset="utf-8">
<?php
$csv = file_get_contents( '/home/hikaru.yamashita/www/fungi/project/sindan/search/k/files/アミガサ.csv' );
$csv = str_replace("、", "，", $csv);
$csv = str_replace("。", "．", $csv);

/* 木構造をつくる */
function toTree($answer, $conditions) {
    $condition = array_shift($conditions);
    if ($conditions) {
        return array($condition => toTree($answer, $conditions));
    } else {
        return array($condition => $answer);
    }
}

$csv = explode("\n", $csv);

$identificationKey = array();
foreach ($csv as $line) {
    $columns = explode(',', $line);
    list($answer, $conditions) = array(array_shift($columns), $columns);

    $identificationKey = array_merge_recursive($identificationKey, toTree($answer, $conditions));
}


/* 木構造から結果を表示する */
function getResults($conditions, &$bookings, $number) {
    $results = array();
    if ($number < 10) {
        $number = "0".$number."";
    }
    foreach ($conditions as $condition => $next) {
        if (is_array($next)) {
            $nextNumber = array_shift($bookings);
            $results[] = "".$number."．".$condition."......".$nextNumber."へ";
            $results = array_merge($results, getResults($next, $bookings, $nextNumber));
        } else {
            $results[] = "".$number."．".$condition."......<span style='color:red;'>「".$next."」の可能性があります．</span>";
        }
    }
    natsort($results);
    return $results;
}

$bookings = range(2, 9999);
$kiroku = '';
$i = 0;
foreach (getResults($identificationKey, $bookings, 1) as $result) {
    echo $result."\n<br>";
}
