<?php

/************************************************************************
    config_default.php を config.php にリネームしてご利用ください。
************************************************************************/

$config = array(
    'output_path' => '',
    'target_dir' => '',
    'ext_pattern' => '',
    'with_sub_dir' => true,
    'output_pattern' => 'full', // dir_name, file_name, full
);

// 出力パス
$config['output_path'] = 'C:\aaa\bbb\ファイル名.txt';

// 取得対象
$config['target_dir'] = 'C:\aaa\bbb';

// 取得対象の拡張子（正規表現）
$config['ext_pattern'] = '/(\.xls|\.xlsx)\z/';

// サブディレクトリを探索するか
$config['with_sub_dir'] = true;

// 出力パターン
$config['output_pattern'] = 'full';


