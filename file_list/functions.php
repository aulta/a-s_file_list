<?php
namespace aulta\scripts;

/**
 * 汎用関数
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

/**
 * 設定内容のチェック
 *
 * ・定義されているか
 * ・型が正しいか
 *
 * @param array $config 設定
 * @param array $rules 設定ルール
 * @return mixed
 */
function checkConfig($config, $rules)
{
    foreach ($rules as $config_key => $rule) {

        // 設定キーが無ければ
        if (! array_key_exists($config_key, $config)) {
            echo $config_key . ' が設定されていません。' . "\n";
            exit();
        }

        // 検証内容がなければ
        if (empty($rule)) {
            continue;
        }

        // 設定値
        $value = $config[$config_key];

        // 型
        switch ($rule['type']) {

            // 配列か
            case 'array':
                if (! is_array($value)) {
                    echo $config_key . ' には配列を指定してください。' . "\n";
                    exit();
                }
                break;

            // 文字列か
            case 'string':
                if (! is_string($value)) {
                    echo $config_key . ' には文字列を指定してください。' . "\n";
                    exit();
                }
                break;

            // 真偽値か
            case 'bool':
                if (! is_bool($value)) {
                    echo $config_key . ' にはbool値を指定してください。' . "\n";
                    exit();
                }
                break;
        }

        // 空値を許可するか、デフォルトは許可しない
        if (! array_key_exists('empty', $rule)) {
            $rule['empty'] = false;
        }

        // 空値を許可しないとき
        if (! $rule['empty']) {
            if (empty($value)) {
                if (! (is_string($value) && $value === '0')) {
                    if (! (is_int($value) && $value === 0)) {
                        echo $config_key . ' は必須です。' . "\n";
                        exit();
                    }
                }
            }
        }

        // 値の種類
        if (! empty($rule['value_type'])) {
            switch ($rule['value_type']) {

                // パス指定
                case 'path':
                    $value = trim($value);
                    $value = str_replace('\\', '/', $value);
                    if (preg_match('/.+\/$/', $value)) {
                        $value = substr($value, 0, - 1);
                    }
            }
        }

        // 1つ上のディレクトリが存在するか
        if (array_key_exists('exists_parent_dir', $rule)) {
            if ($rule['exists_parent_dir']) {
                $s = dirname($value);
                if (! file_exists($s)) {
                    echo $config_key . ' ' . __LINE__ . ' ディレクトリが見つかりません。' . "\n";
                    echo '  ' . $s . "\n";
                    exit();
                }
                if (! is_dir($s)) {
                    echo $config_key . ' ' . __LINE__ . ' ディレクトリが見つかりません。' . "\n";
                    echo '  ' . $s . "\n";
                    exit();
                }
            }
        }

        // ディレクトリが存在するか
        if (array_key_exists('exists_dir', $rule)) {
            if ($rule['exists_dir']) {
                $s = $value;
                if (! file_exists($s)) {
                    echo $config_key . ' ' . __LINE__ . ' ディレクトリが見つかりません。' . "\n";
                    echo '  ' . $s . "\n";
                    exit();
                }
                if (! is_dir($s)) {
                    echo $config_key . ' ' . __LINE__ . ' ディレクトリが見つかりません。' . "\n";
                    echo '  ' . $s . "\n";
                    exit();
                }
            }
        }

        // 値をセット
        $config[$config_key] = $value;
    }

    return $config;
}

/**
 * 指定したパスのファイルとフォルダを取得する
 *
 * @param string $path パス
 * @param string $mode 取得対象
 * @return string[]|string[][]|string[][]
 */
function getDirectoryAndFile($path, $mode = null)
{
    $directory = array();
    $file = array();
    if (substr($path, - 1) == '/') {
        $path = substr($path, 0, - 1);
    }

    if (file_exists($path)) {
        if ($hd = opendir($path)) {
            while (false !== ($name = readdir($hd))) {
                if ($name == '')
                    continue;
                if ($name == '.')
                    continue;
                if ($name == '..')
                    continue;
                $p = $path . '/' . $name;
                if (is_dir($p)) {
                    $directory[] = $name;
                } else if (is_file($p)) {
                    $file[] = $name;
                }
            }
            closedir($hd);
        }
        sort($directory, SORT_STRING);
        sort($file, SORT_STRING);
    }

    if (! is_null($mode)) {
        switch ($mode) {
            case 'directory':
                return $directory;
            case 'file':
                return $file;
        }
    }
    return array(
        'dir' => $directory,
        'file' => $file
    );
}

