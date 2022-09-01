<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\ErrorNotify;

use Eccube\Plugin\AbstractPluginManager;
use Plugin\ErrorNotify\Entity\ErrorLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Plugin\ErrorNotify\Entity\Config;
use Eccube\Entity\BaseInfo;
use Plugin\ErrorNotify\Service\MonologYmlService;
use Plugin\ErrorNotify\Service\ErrorLogService;
/**
 * Class PluginManager.
 */
class PluginManager extends AbstractPluginManager
{

    private $monologYmlService;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->monologYmlService = new MonologYmlService(new ErrorLogService);
    }
    
    /**
     * @param array $meta
     * @param ContainerInterface $container
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function enable(array $meta, ContainerInterface $container)
    {
        /** @var EntityManager $em */
        $em = $container->get('doctrine')->getManager();

        /** @var Config $Config */
        $Config = $em->find(Config::class, 1);
        /** @var BaseInfo $BaseInfo */
        $BaseInfo = $em->find(BaseInfo::class, 1);
        // print_r($BaseInfo);
        if (!$Config) {
            $Config = new Config();
            $Config->setPropertiesFromArray(
                [
                    'from_mail' => $BaseInfo->getEmail01(),
                    'send_mail' => $BaseInfo->getEmail01(),
                    'is_send' => true,
                    'send_level' => 250,
                    'is_record' => true,
                    'record_level' => 250,
                    'record_deduplicated_time' => 60,
                    'send_deduplicated_time' => 60
                ]
            );
            $em->persist($Config);
            $em->flush($Config);
        }
        $this->monologYmlService->generateServicesYml($Config);
    }
}
