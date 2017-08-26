<?php
namespace aulta\scripts;

/**
 * 指定したディレクトリのファイル一覧を作成する
 *
 * @package phpAulta
 * @author takashi shinohara
 * @copyright Copyright (c) 2008, takashi shinohara
 * @link https://aulta.co.jp/
 * @license https://aulta.co.jp/licensed.html
 * @since PHP 5.3.0
 * @version 0.0.1 (2017-08-19 : 2017-08-19)
 * @access public
 */

// 共通ファイルを読み込む
include __DIR__ . '/functions.php';

// 設定内容
$config = null;

// 設定ファイルを読み込む
$f = __DIR__ . '/config.php';
if (! file_exists($f)) {
    echo 'config error' . "\n";
    exit();
}
include $f;
unset($f);

// 設定されてなければ
if (empty($config)) {
    echo 'config error' . "\n";
    exit();
}

// 設定内容のチェック
$config = \aulta\scripts\checkConfig($config, array(
    'output_path' => array(
        'type' => 'string',
        'value_type' => 'path',
        'exists_parent_dir' => true
    ),
    'target_dir' => array(
        'type' => 'string',
        'value_type' => 'path',
        'exists_dir' => true
    ),
    'ext_pattern' => array(
        'type' => 'string'
    ),
    'with_sub_dir' => array(
        'type' => 'bool'
    )
));

// 実行
$list = execute($config['target_dir']);

// 出力
file_put_contents($config['output_path'], implode("\n", $list) . "\n");

// 終了
echo 'complete!' . "\n";

// 実行
function execute($path)
{
    global $config;

    $ret = array();

    // 出力パターンがディレクトリ名のとき
    if ($config['output_pattern'] === 'dir_name') {
        $ret[] = $path;
    }

    // パスを指定してディレクトリとファイルの一覧を取得
    $path_list = \aulta\scripts\getDirectoryAndFile($path);

    // サブディレクトリを調査するとき
    if ($config['with_sub_dir']) {

        // サブディレクトリを再帰
        foreach ($path_list['dir'] as $dir_name) {
            $a = execute($path . '/' . $dir_name);
            $ret = array_merge($ret, $a);
        }
    }

    // 出力パターンがディレクトリ名のとき
    if ($config['output_pattern'] === 'dir_name') {
        return $ret;
    }

    // ファイル一覧
    foreach ($path_list['file'] as $file_name) {

        // 拡張子チェック
        if (! empty($config['ext_pattern'])) {
            if (! preg_match($config['ext_pattern'], $file_name)) {
                continue;
            }
        }

        // リストに追加
        if ($config['output_pattern'] === 'file_name') {

            // ファイル名のみ
            $ret[] = $file_name;

        } else {

            // フルパス
            $ret[] = $path . DIRECTORY_SEPARATOR . $file_name;

        }

    }

    return $ret;
}



