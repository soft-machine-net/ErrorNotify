<?php

namespace Plugin\ErrorNotify\Controller\Admin;

use Eccube\Controller\AbstractController;
use Plugin\ErrorNotify\Form\Type\Admin\ConfigType;
use Plugin\ErrorNotify\Repository\ConfigRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Plugin\ErrorNotify\Service\ErrorLogService;
use Plugin\ErrorNotify\Service\MonologYmlService;

class ConfigController extends AbstractController
{
    /**
     * @var ConfigRepository
     */
    protected $configRepository;

    /**
     * @var ErrorLogService
     */
    private $errorLogService;

    /**
     * @var MonologYmlService
     */
    private $monologYmlService;

    /**
     * ConfigController constructor.
     *
     * @param ConfigRepository $configRepository
     */
    public function __construct(ConfigRepository $configRepository, ErrorLogService $errorLogService, MonologYmlService $monologYmlService)
    {
        $this->configRepository = $configRepository;
        $this->errorLogService = $errorLogService;
        $this->monologYmlService = $monologYmlService;
    }

    /**
     * @Route("/%eccube_admin_route%/error_notify/config", name="error_notify_admin_config")
     * @Template("@ErrorNotify/admin/config.twig")
     */
    public function index(Request $request)
    {
        $Config = $this->configRepository->get(1);
        $form = $this->createForm(ConfigType::class, $Config);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $Config = $form->getData();
            $this->entityManager->persist($Config);
            $this->entityManager->flush();
            $this->monologYmlService->generateServicesYml($Config);
            $this->addSuccess('登録しました。', 'admin');

            return $this->redirectToRoute('error_notify_admin_config');
        }
        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/%eccube_admin_route%/error_notify/errorsample/{level}", name="error_notify_admin_config_errorsample")
     * @Template("@ErrorNotify/admin/sample_error.twig")
     */
    public function error_sample($level){
        // echo $level;
        switch ($level){
            case "debug":
                log_debug($level);
                break;
            case "info";
                log_info($level);
                break;
            case "notice";
                log_notice($level);
                break;
            case "warning";
                log_warning($level);
                break;
            case "error";
                log_error($level);
                break;
            case "critical";
                log_critical($level);
                break;
            case "alert";
                log_alert($level);
                break;
            case "emergency";
                log_emergency($level);
                break;
            default:
                return [];
        }
        return ['level'=>strtoupper($level)];
    }


}