<?php
/*
 * Copyright (c) 
 */

namespace Plugin\ErrorNotify\Service;

use Eccube\Repository\BaseInfoRepository;

/**
 * エラーログ取得クラス
 */
class MonologYmlService
{

    /**
     * @var ErrorLogService
     */
    private $errorLogService;

    /**
     * ShopController constructor.
     *
     * @param ErrorLogService
     */
    public function __construct(ErrorLogService $errorLogService)
    {
        $this->errorLogService = $errorLogService;
    }

        /**
     * 設定ファイル（services.yml）ファイルの生成
     * 
     * @param Config $Config Configentity
     * @return Bool $result
     */
    public function generateServicesYml($Config = null){
        if($Config) {
            //ベースやムルファイルの設定
            // print_r(getenv());
            // $this->app;
            $base_dir = __DIR__.'/../Resource/config/';

            //設定ベースファイルを取得
            $sample_yml = file_get_contents($base_dir.'services-sample-base.yml');
            if($Config->getIsRecord()) $sample_yml .= file_get_contents($base_dir.'services-sample-db.yml');
            if($Config->getIsSend()) $sample_yml .= file_get_contents($base_dir.'services-sample-mail.yml');

            //取得したベースファイルの内容を書き換え
            $services_yml = $this->getConfigReplaces($Config, $sample_yml);
            
            //設定ファイルの保存
            // echo "aa";
            file_put_contents($base_dir.'services.yml', $services_yml);
        }
    }

    /**
     * 設定ファイルの文字列置き換え内容の生成
     * @param Config $Config PluginConfigEntity
     * @param String $sample_yml　yml ベーステキスト
     * 
     * @return String $services_yml　パラメータの置き換えをしたyml用テキスト
     */
    public function getConfigReplaces($Config = null, $sample_yml = ""){
        $replaces = [0=>null,1=>null,2=>null,3=>null,4=>null];
        if($Config != null){
            $replaces[0] = ($Config->getFromMail())?$Config->getFromMail():"from@example.com";
            $replaces[1] = ($Config->getSendMail())?$Config->getSendMail():"to@example.com";
            $replaces[2] = $this->errorLogService::$monologLevels[$Config->getSendLevel()];
            $replaces[3] = $this->errorLogService::$monologLevels[$Config->getRecordLevel()];
            $replaces[4] = "[streamed" . ($Config->getIsRecord() ? ", deduplicated_doctrine" : "" ) . ($Config->getIsSend()?", deduplicated_mailer":"")."]"; 
            $replaces[5] = $Config->getRecordDeduplicatedTime();
            $replaces[6] = $Config->getSendDeduplicatedTime();
        }
        $services_yml = str_replace(
            [
                '%%from_email%%',
                '%%to_email%%',
                '%%send_level%%',
                '%%record_level%%',
                "%%members%%",
                '%%record_deduplicated_time%%',
                '%%send_deduplicated_time%%',
            ],
            $replaces,
            $sample_yml
        );
        return $services_yml;
    }
}
