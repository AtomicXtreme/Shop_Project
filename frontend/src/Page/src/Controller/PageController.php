<?php

namespace Frontend\Page\Controller;

use Dot\Controller\AbstractActionController;
use Frontend\Page\Service\PageService;
use Frontend\Product\Service\ProductService;
use Frontend\Product\Service\StockService;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Dot\AnnotatedServices\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;

class PageController extends AbstractActionController
{

    /** @var RouterInterface $router */
    protected RouterInterface $router;

    /** @var PageService $pageService */
    protected PageService $pageService;

    /** @var ProductService */
    protected ProductService $productService;

    /** @var StockService  */
    protected StockService $stockService;

    /** @var TemplateRendererInterface $template */
    protected TemplateRendererInterface $template;

    /**
     * PageController constructor.
     * @param PageService $pageService
     * @param RouterInterface $router
     * @param TemplateRendererInterface $template
     *
     * @Inject({ProductService::class, StockService::class, PageService::class, RouterInterface::class, TemplateRendererInterface::class})
     */
    public function __construct(ProductService $productService,StockService $stockService,PageService $pageService, RouterInterface $router, TemplateRendererInterface $template)
    {
        $this->productService = $productService;
        $this->stockService = $stockService;
        $this->pageService = $pageService;
        $this->router = $router;
        $this->template = $template;
    }

    /**
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        $productArray = $this->productService->getAllProducts();
        foreach ($productArray as $product){
            $singleProduct = $this->productService->getRepository()->findByUuid($product->getUuid());
            $arrayStocks[] = count($this->stockService->getRepository()->getStockByProduct($singleProduct));
        }

        return new HtmlResponse($this->template->render('product::product-home',
            ['products' => $productArray,
                'stocks' => $arrayStocks
            ]));
    }

//    /**
//     * @return ResponseInterface
//     */
//    public function homeAction(): ResponseInterface
//    {
//        return new HtmlResponse(
//            $this->template->render('page::home', [
//
//            ])
//        );
//    }
//
//    /**
//     * @return ResponseInterface
//     */
//    public function aboutUsAction(): ResponseInterface
//    {
//        return new HtmlResponse(
//            $this->template->render('page::about', [
//
//            ])
//        );
//    }
//
//    /**
//     * @return ResponseInterface
//     */
//    public function premiumContentAction(): ResponseInterface
//    {
//        return new HtmlResponse(
//            $this->template->render('page::premium-content', [
//
//            ])
//        );
//    }
//
//    /**
//     * @return ResponseInterface
//     */
//    public function whoWeAreAction(): ResponseInterface
//    {
//        return new HtmlResponse(
//            $this->template->render('page::who-we-are', [
//
//            ])
//        );
//    }
}
