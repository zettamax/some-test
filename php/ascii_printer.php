<?php

const PADDING = 2;

$items = [
    [
        'Name' => 'Trixie',
        'Color' => 'Green',
        'Element' => 'Earth',
        'Likes' => 'Flowers',
        'Extra' => 'Foo',
        'Averyveryveryveryveryveryverylongcolumnname' => 'Bar',
    ],
    [
        'Name' => 'Tinkerbell',
        'Element' => 'Air',
        'Likes' => 'Singing',
        'Color' => 'Blue',
        'Extra' => 'Averyveryveryveryveryverylongstring',
    ],
    [
        'Name' => 'Blum',
        'Element' => 'Water',
        'Likes' => 'Dancing',
        'Color' => 'Pink',
    ],
];
$keys = array_keys(reset($items));
$columns = count($keys);
$tabledItems[] = $keys;
$colorColNum = array_search('Color', $keys);

$colLengths = array_map(function ($value) {
    return strlen($value);
}, $keys);

foreach ($items as $item) {
    $row = [];

    foreach ($keys as $i => $key) {
        $value = $item[$key] ?? null;
        $row[] = $value;
        
        if ($value && ($colLengths[$i] < strlen($value))) {
            $colLengths[$i] = strlen($value);
        }
    }

    $tabledItems[] = $row;
}

$border = '+';
foreach ($colLengths as $length) {
    $border .= str_repeat('-', $length + PADDING * 2) . '+';
}

$lines = [$border];
$isHead = true;
foreach ($tabledItems as $item) {
    $line = '';
    foreach ($item as $i => $col) {
        $realLen = strlen($col);
        $freeSpace = $colLengths[$i] - $realLen;
        $leftPadding = $isHead ? intdiv($freeSpace, 2) + PADDING : PADDING;
        $rightPadding = $colLengths[$i] + PADDING * 2 - $realLen - $leftPadding;

        $colorizedCol = $col;
        if ($i === $colorColNum) {
            $color = strtolower($col);
            $colorizedCol = "<span style=\"color: {$color};\">{$col}</span>";
        }

        $line .= '|' . str_repeat(' ', $leftPadding) . $colorizedCol
            . str_repeat(' ', $rightPadding);
    }

    $lines[] = $line . '|';
    $lines[] = $border;
    $isHead = false;
}

$table = join("\n", $lines);

echo "<pre>{$table}</pre>";