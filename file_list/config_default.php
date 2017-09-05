<?php

/************************************************************************
    config_default.php を config.php にリネームしてご利用ください。
************************************************************************/

// 設定
$config = array(

    // 出力パス
    'output_path' => 'C:\aaa\bbb\ファイル名.txt',

    // 取得対象
    'target_dir' => 'C:\aaa\bbb',

    // 取得対象の拡張子（正規表現）
    'ext_pattern' => '/(\.xls|\.xlsx)\z/',

    // 取得するサブディレクトリの階層
    'sub_dir_hierarchy_count' => 999,

    // 出力パターン
    'output_pattern' => 'full', // dir_name, file_name, full
);

