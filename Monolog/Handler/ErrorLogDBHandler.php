<?php
/*
 * Copyright (c) 
 */

namespace Plugin\ErrorNotify\Monolog\Handler;


use Plugin\ErrorNotify\Entity\ErrorLog;
use Plugin\ErrorNotify\Service\ErrorlogService;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Formatter\HtmlFormatter;
use Monolog\Logger;

/**
 * エラーログ取得クラス
 */
class ErrorLogDBHandler extends AbstractProcessingHandler
{
    private $entityManager;
    private $errorLogService;

    public function __construct(EntityManagerInterface $entityManager,ErrorLogService $errorLogService,$logLevel)
    {
        // echo $logLevel;
        $this->errorLogService = $errorLogService;
        parent::__construct(array_search($logLevel, $this->errorLogService::$monologLevels),true);
        $this->entityManager = $entityManager;
        $this->setFormatter(new HtmlFormatter);
    }

    /**
     * {@inheritdoc}
     */
    public function handleBatch(array $records)
    {
        //エラー優先度高いログの記録
        $highestRecord = $this->getHighestRecord($records);
        $message = $this->processRecord($highestRecord);
        $content = $this->getFormatter()->formatBatch([$message]);

        // 最大レベルのログレベルのチェック　levelより低ければreturn処理を停止
        if( $highestRecord['level'] < $this->level ) return ;

        $log = new ErrorLog();
        $log->setDatetime($highestRecord['datetime']);
        $log->setLevel($highestRecord['level_name']);
        $log->setMethod((isset($highestRecord['extra']['http_method']))?$highestRecord['extra']['http_method']:"a");
        $log->setUrl((isset($highestRecord['extra']['url']))?$highestRecord['extra']['url']:"a");
        $log->setUserAgent((isset($highestRecord['extra']['user_agent']))?$highestRecord['extra']['user_agent']:"a");
        $log->setIpAddress((isset($highestRecord['extra']['ip']))?$highestRecord['extra']['ip']:"unknown");
        $log->setReferrer((isset($highestRecord['extra']['referrer']))?$highestRecord['extra']['referrer']:"unknown");
        $log->setContent($content);
        $log->setIsFixed(false);//初期値をセット

        //LogをEntity Managerの管理下に置く
        $this->entityManager->clear(ErrorLog::class);
        $this->entityManager->persist($log);
        $this->entityManager->flush();
        $this->entityManager->commit();
    }

    protected function write(array $record){}

    /**
     * レコード一覧から一番優先度の高いレコードを返す
     * @param array $records 
     * @return array $record
     */
    private function getHighestRecord(array $records){
        $highestRecord = null;
        foreach ($records as $record) {
            if ($highestRecord === null || $highestRecord['level'] < $record['level']) {
                $highestRecord = $record;
            }
        }
        return $highestRecord;
    }
}
