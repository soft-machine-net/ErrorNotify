<?php
/*
 * Copyright (c) 
 */

namespace Plugin\ErrorNotify\Service;


use Plugin\ErrorNotify\Entity\ErrorLog;

/**
 * エラーログ取得クラス
 */
class ErrorLogService
{
    public static $monologLevels = [
        100 => 'DEBUG',
        200 => 'INFO',
        250 => 'NOTICE',
        300 => 'WARNING',
        400 => 'ERROR',
        500 => 'CRITICAL',
        550 => 'ALERT',
        600  => 'EMERGENCY'
    ];


        /**
     * エラーログデータの取得機能
     * 
     * @param array $param urlのクエリデータの取得
     * @return array $ErrorLogs ErrorLogEntityの配列
     */
    public function getLogData($param){
        $logfile = $this->getLogFile($param["date"]);
        $lines = explode("\n",$logfile);
        $logs = [];
        foreach($lines as $key => $line) {
            if(!empty($line) && $line != ""){
                $datas = explode("///",$line);
                $log = [];
                foreach($datas as $key => $data) {
                    $key = explode("::",$data)[0];
                    $value = explode("::",$data)[1];
                    $log[trim($key)] = trim($value);
                }
                $logs[] = $log;
            }
        }
        //抽出するログレベルの絞り込み
        $levels = array_slice($this->monologLevels,$param['min_level']);
        $ErrorLogs = [];
        foreach($logs as $key => $log){
            if(
                in_array($log['level'],$levels) //ログレベルの確認
            ){
                $ErrorLogs[] = new ErrorLog($log);
            }
        }
        return $ErrorLogs;
    }

    /**
     * ログファイルの取得機能
     * 日付指定によりファイルを特定
     * 
     * @param string $date フォーマット Y-m-d
     * @return string $logfile ログファイルのテキストデータ
     */
    public function getLogFile($date){
        $basedir = $_SERVER['DOCUMENT_ROOT'].'/var/log/error/';
        if(!file_exists($basedir.'error-'.$date.'.log')){
            return "";
        }
        $logfile = file_get_contents($basedir.'error-'.$date.'.log');
        return $logfile;
    }

    /**
     * 保存されているログファイルの日付一覧を取得
     * 
     * @return array $dates [Y-m-d]
     */
    public function getLogDates(){
        $dir = $_SERVER['DOCUMENT_ROOT'].'/var/log/error/';
        // 既知のディレクトリをオープンし、その内容を読み込みます。
        $dates = [];
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if(filetype($dir . $file) == "file"){
                        $date = str_replace(["error-",".log"],["",""],$file);
                        $dates[] = $date;
                    }                    
                }
                closedir($dh);
            }
        }
        return $dates;
    }
    
}
