<?php

namespace Plugin\ErrorNotify\Controller\Admin;

use Eccube\Controller\AbstractController;
use Plugin\ErrorNotify\Form\Type\Admin\ConfigType;
use Plugin\ErrorNotify\Repository\ConfigRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Eccube\Repository\Master\PageMaxRepository;
use Plugin\ErrorNotify\Entity\ErrorLog;
use Plugin\ErrorNotify\Service\ErrorLogService;
use Doctrine\ORM\EntityManagerInterface;
use Plugin\ErrorNotify\Repository\ErrorLogRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ErrorLogController extends AbstractController
{
    /**
     * @var PageMaxRepository
     */
    protected $pageMaxRepository;

    /**
     * @var ErrorLogService
     */
    private $errorLogService;

    /**
     * @var ErrorLogRepository
     */
    private $errorLogRepository;


    /**
     * ErrorLogController constructor.
     * 
     * @param PageMaxRepository $pageMaxRepository
     */
    public function __construct(
        PageMaxRepository $pageMaxRepository,
        ErrorLogService $errorLogService,
        ErrorLogRepository $errorLogRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->pageMaxRepository = $pageMaxRepository;
        $this->errorLogService = $errorLogService;
        $this->errorLogRepository = $errorLogRepository;
    }

    /**
     * @Route("/%eccube_admin_route%/error_notify/list", name="error_notify_list")
     * @Route("/%eccube_admin_route%/error_notify/page/{page_no}", requirements={"page_no" = "\d+"}, name="admin_error_notify_page", methods={"GET", "POST"})
     * @Template("@ErrorNotify/admin/ErrorLog/list.twig")
     */
    public function index(Request $request, $page_no = 1, PaginatorInterface $paginator)
    {
        //ログの表示レベルの取得と設定
        if(!isset($param['min_level']) or empty($param['min_level'])){
            $param['min_level'] = '0';
        }
        $levels = $this->errorLogService::$monologLevels;

        /**
         * ページの表示件数は, 以下の順に優先される.
         * - リクエストパラメータ
         * - セッション
         * - デフォルト値
         * また, セッションに保存する際は mtb_page_maxと照合し, 一致した場合のみ保存する.
         **/
        $page_count = $this->session->get('eccube.admin.product.search.page_count',
            $this->eccubeConfig->get('eccube_default_page_count'));

        $page_count_param = (int) $request->get('page_count');
        $pageMaxis = $this->pageMaxRepository->findAll();

        if ($page_count_param) {
            foreach ($pageMaxis as $pageMax) {
                if ($page_count_param == $pageMax->getName()) {
                    $page_count = $pageMax->getName();
                    $this->session->set('eccube.admin.product.search.page_count', $page_count);
                    break;
                }
            }
        }


        //クエリビルだの作成
        $qb = $this->errorLogRepository->createQueryBuilder("e")
            ->orderBy('e.id', 'DESC')
        ;
        // print_r($qb->getQuery()->getResult());
        //ページネーションの作成
        $pagination = $paginator->paginate(
            $qb,
            $page_no,
            $page_count
        );
        
        return [
            'pagination' => $pagination,
            'page_count' => $page_count,
            'pageMaxis' => $pageMaxis,
            // 'date' => $param['date'],
            // 'dates' => $dates,
            'min_level' => $param['min_level'],
            'levels' => $levels,
        ];
    }

    /**
     * 商品詳細画面.
     * @Route("/%eccube_admin_route%/error_notify/detail/{id}", name="error_notify_detail", methods={"GET"}, requirements={"id" = "\d+"})
     * @Template("@ErrorNotify/admin/ErrorLog/detail.twig")
     * @ParamConverter("ErrorLog", options={"repository_method" = "get"})
     *
     * @param Request $request
     * @param ErrorLog $ErrorLog
     *
     * @return array
     */
    public function detail(Request $request, ErrorLog $ErrorLog)
    {
        if (!$ErrorLog) {
            throw new NotFoundHttpException();
        }

        return [
            'ErrorLog' => $ErrorLog,
        ];
    }
}