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
    'sub_dir_hierarchy_count' => array(
        'type' => 'integer'
    ),
    'with_target_dir' => array(
        'type' => 'bool'
    )
));

// 実行
$list = execute($config['target_dir'], $config['sub_dir_hierarchy_count']);

// 取得対象のパスを含めないとき
if ( ! $config['with_target_dir']) {
    foreach($list as $i => $line) {
        if (strpos($line, $config['target_dir']) === 0) {
            $list[$i] = mb_substr($line, mb_strlen($config['target_dir']));
        }
    }
}

// 出力
file_put_contents($config['output_path'], implode("\n", $list) . "\n");

// 終了
echo 'complete!' . "\n";

// 実行
function execute($path, $sub_dir_count)
{
    global $config;

    $ret = array();

    // 出力パターンが「ファイル名」でないとき
    if ($config['output_pattern'] !== 'file_name') {
        $ret[] = $path;
    }

    // パスを指定してディレクトリとファイルの一覧を取得
    $path_list = \aulta\scripts\getDirectoryAndFile($path);

    // サブディレクトリを調査するとき
    if ($sub_dir_count <= 0) {
        return $ret;
    }

    // サブディレクトリを再帰
    foreach ($path_list['dir'] as $dir_name) {
        $a = execute($path . '/' . $dir_name, ( $sub_dir_count - 1 ));
        $ret = array_merge($ret, $a);
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
            $ret[] = $path . '/' . $file_name;

        }

    }

    return $ret;
}



