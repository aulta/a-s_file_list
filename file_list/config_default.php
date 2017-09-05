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

    // 取得するサブディレクトリの階層 ※現実的に999階層は存在しないので実質的に無制限の意味
    'sub_dir_hierarchy_count' => 999,

    // 出力パターン
    'output_pattern' => 'full', // dir_name, file_name, full

    // 取得対象のパスを出力に含めるか
    'with_target_dir' => true,
);


// 設定サンプル
// 下記のように、複数の設定を記しておき、「見出し下の末尾 / 」の有無で
// 有効・無効を切り替えると手軽です

/*************************************************************************
 * 〇〇向けの設定
 *************************************************************************/  // ← 無効にするときはここの末尾の / を外す
$config = array(
    'output_path'             => 'C:\aaa\bbb\ファイル名.txt',
    'target_dir'              => 'C:\aaa\bbb',
    'ext_pattern'             => '/(\.xls|\.xlsx)\z/',
    'sub_dir_hierarchy_count' => 999,
    'output_pattern'          => 'full', // dir_name, file_name, full
    'with_target_dir' => true,
);


/*************************************************************************
 * 〇〇向けの設定
 *************************************************************************  // ← 有効にするときはここの末尾に / を付ける
$config = array(
    'output_path'             => 'C:\aaa\bbb\ファイル名.txt',
    'target_dir'              => 'C:\aaa\bbb',
    'ext_pattern'             => '/(\.xls|\.xlsx)\z/',
    'sub_dir_hierarchy_count' => 999,
    'output_pattern'          => 'full', // dir_name, file_name, full
    'with_target_dir' => true,
);


/*************************************************************************
 * 〇〇向けの設定
 *************************************************************************
$config = array(
    'output_path'             => 'C:\aaa\bbb\ファイル名.txt',
    'target_dir'              => 'C:\aaa\bbb',
    'ext_pattern'             => '/(\.xls|\.xlsx)\z/',
    'sub_dir_hierarchy_count' => 999,
    'output_pattern'          => 'full', // dir_name, file_name, full
    'with_target_dir' => true,
);


/*************************************************************************
 * 〇〇向けの設定
 *************************************************************************
$config = array(
    'output_path'             => 'C:\aaa\bbb\ファイル名.txt',
    'target_dir'              => 'C:\aaa\bbb',
    'ext_pattern'             => '/(\.xls|\.xlsx)\z/',
    'sub_dir_hierarchy_count' => 999,
    'output_pattern'          => 'full', // dir_name, file_name, full
    'with_target_dir' => true,
);


/*************************************************************************
 * 〇〇向けの設定
 *************************************************************************
$config = array(
    'output_path'             => 'C:\aaa\bbb\ファイル名.txt',
    'target_dir'              => 'C:\aaa\bbb',
    'ext_pattern'             => '/(\.xls|\.xlsx)\z/',
    'sub_dir_hierarchy_count' => 999,
    'output_pattern'          => 'full', // dir_name, file_name, full
    'with_target_dir' => true,
);


/*************************************************************************/

