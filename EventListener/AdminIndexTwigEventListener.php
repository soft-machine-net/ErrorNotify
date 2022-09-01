<?php
/*
 * Copyright (c) 2018 VeriTrans Inc., a Digital Garage company. All rights reserved.
 * http://www.veritrans.co.jp/
 */
namespace Plugin\ErrorNotify\EventListener;

use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


/**
 * ErrorNotifyプラグインのイベントクラス
 * @author develop
 *
 */
class AdminIndexTwigEventListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            '@admin/index.twig' => 'handle'
        ];
    }
    public function handle(TemplateEvent $event): void
    {
        // $event->setParameter('someVar', 'abc');
        // $event->addSnippet('@ErrorNotify/admin/dashboard.twig');
    }
}