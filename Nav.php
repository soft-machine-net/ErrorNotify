<?php

namespace Plugin\ErrorNotify;

use Eccube\Common\EccubeNav;

class Nav implements EccubeNav
{
    public static function getNav()
    {
        return [
            'setting' => [
                'children' => [
                    //設定項目にerronotify用のエラーログ項目を追加
                    'error_notify' => [
                        'name' => 'サイトログ確認',
                        'url' => 'error_notify',
                        'children' => [
                            //DBに登録されたエラー一覧ページ
                            'index' => ['name' => 'エラーログ', 'url' => 'error_notify_list',],
                            //エラーが出ているURL一覧
                            // 'error_urls' => ['name' => 'エラー検出URL', 'url' => 'error_notiry_urls'],
                            //ErrorNotifyの設定絵画面
                            'setting' => ['name' => '設定', 'url' => 'error_notify_admin_config',]
                        ]
                    ]
                ]
            ]
        ];
    }
}
