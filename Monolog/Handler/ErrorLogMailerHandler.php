<?php
/*
 * Copyright (c) 
 */

namespace Plugin\ErrorNotify\Monolog\Handler;

use Monolog\Handler\SwiftMailerHandler;
use Plugin\ErrorNotify\Service\ErrorlogService;
use Monolog\Formatter\LineFormatter;
use Monolog\Formatter\HtmlFormatter;
use Monolog\Logger;
use \Swift_Mailer;

/**
 * NativeMailerを継承したカスタムメーラー
 * 
 */
class ErrorLogMailerHandler extends SwiftMailerHandler
{
    private $errorLogService = null;

    /**
     * @param \Swift_Mailer           $mailer  The mailer to use
     * @param callable|\Swift_Message $message An example message for real messages, only the body will be replaced
     * @param int                     $level   The minimum logging level at which this handler will be triggered
     * @param bool                    $bubble  Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct($transport,ErrorLogService $errorLogService, $level, $to, $from)
    {
        $mailer = new \Swift_Mailer($transport);
        $message = new \Swift_Message();
        $message->setContentType('text/html');
        $message->setTo($to);
        $message->setFrom($from);
        $message->setSubject('Error notiy message "%message%"');
        $this->errorLogService = $errorLogService;
        $this->setFormatter(new HtmlFormatter);
        parent::__construct($mailer,$message,array_search($level, $this->errorLogService::$monologLevels), true);
    }

    /**
     * {@inheritdoc}
     */
    public function handleBatch(array $records)
    {
        $messages = array();
        foreach ($records as $record) {
            if ($record['level'] < $this->level) {
                continue;
            }
            $messages[] = $this->processRecord($record);
        }

        // 最大レベルのログを取得して判定
        $highestRecord = $this->getHighestRecord($records);
        if( $highestRecord['level'] < $this->level ) return ;

        if (!empty($messages)) {
            $this->send((string) $this->getFormatter()->formatBatch($messages), $messages);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function send($content, array $records)
    {
        $this->mailer->send($this->buildMessage($content, $records));
    }
}
