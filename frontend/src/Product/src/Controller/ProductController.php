<?php

namespace Frontend\Product\Controller;

use Doctrine\ORM\NonUniqueResultException;
use Dot\AnnotatedServices\Annotation\Inject;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Dot\Controller\AbstractActionController;
use Dot\FlashMessenger\FlashMessenger;
use Dot\Mail\Exception\MailException;
use Fig\Http\Message\RequestMethodInterface;
use Frontend\Product\Entity\Category;
use Frontend\Product\Entity\Message;
use Frontend\Product\Entity\Order;
use Frontend\Product\Entity\Product;
use Frontend\Product\Entity\Stock;
use Frontend\Product\Form\MessageForm;
use Frontend\Product\Service\MessageService;
use Frontend\Product\Service\OrderService;
use Frontend\Product\Service\ProductService;
use Frontend\User\Service\UserService;
use Frontend\Product\Service\CategoryService;
use Frontend\Product\Service\StockService;
use Frontend\Plugin\FormsPlugin;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;


class ProductController extends AbstractActionController
{
    /** @var RouterInterface $router */
    protected RouterInterface $router;

    /** @var TemplateRendererInterface $template */
    protected TemplateRendererInterface $template;

    /** @var ProductService $productService */
    protected ProductService $productService;

    /**
     * @var CategoryService
     */
    protected CategoryService $categoryService;

    /** @var MessageService  */
    protected MessageService $messageService;

    /** @var StockService  */
    protected StockService $stockService;

    /** @var UserService  */
    protected UserService $userService;

    /** @var OrderService  */
    protected OrderService $orderService;

    /** @var AuthenticationServiceInterface $authenticationService */
    protected AuthenticationServiceInterface $authenticationService;

    /** @var FlashMessenger $messenger */
    protected FlashMessenger $messenger;

    /** @var FormsPlugin $forms */
    protected FormsPlugin $forms;

    /** @var array $config */
    protected $config;

    /**
     * UserController constructor.
     * @param ProductService $productService
     * @param CategoryService $categoryService
     * @param RouterInterface $router
     * @param TemplateRendererInterface $template
     * @param AuthenticationService $authenticationService
     * @param FlashMessenger $messenger
     * @param FormsPlugin $forms
     * @Inject({
     *     ProductService::class,
     *     CategoryService::class,
     *     MessageService::class,
     *     StockService::class,
     *     OrderService::class,
     *     UserService::class,
     *     RouterInterface::class,
     *     TemplateRendererInterface::class,
     *     AuthenticationService::class,
     *     FlashMessenger::class,
     *     FormsPlugin::class,
     *     "config"
     *     })
     */
    public function __construct(
        ProductService            $productService,
        CategoryService           $categoryService,
        MessageService            $messageService,
        StockService              $stockService,
        OrderService              $orderService,
        UserService               $userService,
        RouterInterface           $router,
        TemplateRendererInterface $template,
        AuthenticationService     $authenticationService,
        FlashMessenger            $messenger,
        FormsPlugin               $forms,
        array                     $config = []
    )
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->messageService = $messageService;
        $this->stockService = $stockService;
        $this->orderService = $orderService;
        $this->userService = $userService;
        $this->router = $router;
        $this->template = $template;
        $this->authenticationService = $authenticationService;
        $this->messenger = $messenger;
        $this->forms = $forms;
        $this->config = $config;
    }

    /**
     * Get all products from Db and render them on the home page
     * @return ResponseInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function homeAction(): ResponseInterface
    {
        $arrayStocks = [];
        $productArray = $this->productService->getAllProducts();
        /** @var Product $product */
        foreach ($productArray as $product) {
            $singleProduct = $this->productService->getRepository()->findByUuid($product->getUuid());
            $arrayStocks[] = count($this->stockService->getRepository()->getStockByProduct($singleProduct));
        }

        return new HtmlResponse($this->template->render('product::product-home',
            ['products' => $productArray,
                'stocks' => $arrayStocks
            ]));
    }

    /**
     * @return ResponseInterface
     */
    public function smartphoneAction(): ResponseInterface
    {
        $arrayStocks = [];
        try {
            $categoryArray = $this->categoryService->getRepository()->getCategory('Smartphone');
        } catch (NonUniqueResultException $exception){
            return new RedirectResponse($this->router->generateUri("product", ['action' => 'home']));
        }

        $productArray = $this->productService->getRepository()->getProductsByCategory($categoryArray);
        /** @var Product $product */
        foreach ($productArray as $product) {
            try {
                $singleProduct = $this->productService->getRepository()->findByUuid($product->getUuid());
            }catch (NonUniqueResultException $exception){
                return new RedirectResponse($this->router->generateUri("product", ['action' => 'home']));
            }
            $arrayStocks[] = count($this->stockService->getRepository()->getStockByProduct($singleProduct));
        }
        return new HtmlResponse($this->template->render('product::product-smartphone',
            ['smart' => $productArray,
                'stocks' => $arrayStocks
            ]));
    }

    /**
     * Render only pc products when we select Desktop Pc category
     * @return ResponseInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function pcAction(): ResponseInterface
    {
        $arrayStocks = [];
        $categoryArray = $this->categoryService->getRepository()->getCategory('Desktop Pc');
        $productArray = $this->productService->getRepository()->getProductsByCategory($categoryArray);
        /** @var Product $product */
        foreach ($productArray as $product) {
            $singleProduct = $this->productService->getRepository()->findByUuid($product->getUuid());
            $arrayStocks[] = count($this->stockService->getRepository()->getStockByProduct($singleProduct));
        }
        return new HtmlResponse($this->template->render('product::product-desktop',
            ['desk' => $productArray,
                'stocks' => $arrayStocks
            ]));
    }

    /**
     * Render only tv products when we select Tv category
     * @return ResponseInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function tvAction(): ResponseInterface
    {
        $arrayStocks = [];
        $categoryArray = $this->categoryService->getRepository()->getCategory('Tv');
        $productArray = $this->productService->getRepository()->getProductsByCategory($categoryArray);
        /** @var Product $product */
        foreach ($productArray as $product) {
            $singleProduct = $this->productService->getRepository()->findByUuid($product->getUuid());
            $arrayStocks[] = count($this->stockService->getRepository()->getStockByProduct($singleProduct));
        }

        return new HtmlResponse($this->template->render('product::product-tv',
            ['tv' => $productArray,
                'stocks' => $arrayStocks
            ]));
    }

    /**
     * Render all details of a specific product
     * @return ResponseInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function detailAction(): ResponseInterface
    {
        $uuid = $this->getRequest()->getAttribute('uuid');
        $product = $this->productService->getRepository()->findByUuid($uuid);
        $messages = $this->messageService->getRepository()->getAllMessagesByProduct($product);
        $prodStock = count($this->stockService->getRepository()->getStockByProduct($product));
        return new HtmlResponse($this->template->render('product::product-detail',
            ['details' => $product,
                'messages' => $messages,
                'stock' => $prodStock
            ]));
    }

    /**
     * Get all details from Message Form only if the data is valid and if the user is logged in
     * after that data is processed and inserted into DB.
     * @return ResponseInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function messageAction(): ResponseInterface
    {
        $form = new MessageForm();
        $request = $this->getRequest();
        $uuid = $this->getRequest()->getAttribute('uuid');
        $productDetail = $this->productService->getRepository()->findByUuid($uuid);

        if ($request->getMethod() === RequestMethodInterface::METHOD_POST) {
            $data = $request->getParsedBody();
            $form->setData($data);

            if ($form->isValid()) {
                $dataForm = $form->getData();
                $userIdentity = $this->authenticationService->getIdentity();
                if (empty($userIdentity)) {
                    $this->messenger->addError('You must be logged in to send feedback!');
                    return new RedirectResponse($request->getUri(), 303);
                } else if ($userIdentity != null) {
                    $userIdentity = $userIdentity->getUuid();
                    $user = $this->userService->findByUuid($userIdentity)->getDetail();
                    $processData = new Message($user, $productDetail, $dataForm['title'], $dataForm['text']);
                    $this->messageService->getRepository()->saveMessage($processData);
                    return new HtmlResponse($this->template->render('product::product-message-sent'));
                }
            } else {
                $this->messenger->addError($this->forms->getMessages($form));
                return new RedirectResponse($request->getUri(), 303);
            }
        }
        return new HtmlResponse($this->template->render('product::product-message',
            ['form' => $form]));
    }

    /**
     * Render the shopping cart
     * @return ResponseInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function checkoutAction(): ResponseInterface
    {
        if (!empty($_SESSION['product'])) {
            $productsInCart = $_SESSION['product'];
            foreach ($productsInCart as $key => $value) {
                $prodID[] = [
                    'uuid' => $key,
                    'name' => $this->productService->getRepository()->findByUuid($key)->getTitle(),
                    'price' => $this->productService->getRepository()->findByUuid($key)->getPrice(),
                    'nr' => $value['NR'],
                    'prodTotal' => $this->productService->getRepository()->findByUuid($key)->getPrice() * $value['NR']
                ];
            }
            $arrSum = array_sum(array_column($prodID, 'prodTotal'));
            return new HtmlResponse($this->template->render('product::product-cart',
                ['products' => $prodID,
                    'total' => $arrSum
                ]));
        }
        return new HtmlResponse($this->template->render('product::product-cart', ['products' => '']));
    }

    /**
     * Function that add products in cart
     * we add selected product only if we have that specific product on stock
     * if Session contains already that specific product we increment quantity of the product.
     * @return ResponseInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function addToCartAction(): ResponseInterface
    {
        $uuid = $this->getRequest()->getParsedBody();
        $product = $this->productService->getRepository()->findByUuid($uuid['prodID']);
        $stock = $this->stockService->getRepository()->getStockByProduct($product);
        if (!empty($stock)) {
            if (isset($_SESSION["product"][$uuid['prodID']]) && count($stock) > $_SESSION["product"][$uuid['prodID']]['NR']) {
                $_SESSION["product"][$uuid['prodID']]['NR']++;
            } else if (!isset($_SESSION["product"][$uuid['prodID']])) {
                $_SESSION["product"][$uuid['prodID']] = ['NR' => 1];
            } else if (count($stock) == $_SESSION["product"][$uuid['prodID']]['NR']) {
                $_SESSION["product"][$uuid['prodID']] = ['NR' => count($stock)];
            }
        }
        return new JsonResponse(['result' => $uuid['prodID']]);
    }

    /**
     * Remove from shopping cart function
     * @return ResponseInterface
     */
    public function removeFromCartAction(): ResponseInterface
    {
        $uuid = $this->getRequest()->getParsedBody();
        if (isset($_SESSION["product"][$uuid['prodID']])) {
            $_SESSION["product"][$uuid['prodID']]['NR']--;
        }
        if ($_SESSION["product"][$uuid['prodID']]['NR'] == 0) {
            unset($_SESSION["product"][$uuid['prodID']]);
        }
        return new JsonResponse(['result' => $uuid['prodID']]);
    }

    /**
     * Empty shopping cart function
     * @return ResponseInterface
     */
    public function emptyCartAction(): ResponseInterface
    {
        $_SESSION["product"] = [];
        return new RedirectResponse($this->router->generateUri("product", ['action' => 'checkout']));
    }

    /**
     * Send order function
     * @return ResponseInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function sendOrderAction(): ResponseInterface
    {
        $userIdentity = $this->authenticationService->getIdentity();
        if (empty($userIdentity)) {
            $this->messenger->addError('You must be logged in!');
            return new RedirectResponse($this->router->generateUri("user", ['action' => 'login']));
        }
        $userID = $userIdentity->getUuid();
        $user = $this->userService->findByUuid($userID);
        $order = new Order($user);
        if (!empty($_SESSION['product'])) {
            $productsInCart = $_SESSION['product'];
            foreach ($productsInCart as $productUuid => $value) {
                $product = $this->productService->getRepository()->findByUuid($productUuid);
                $productsInStock = $product->getStocks($value['NR']);
                if (is_null($product->getStocks($value['NR']))) {
                    exit("No prod in stock");
                }
                /** @var Stock $stock */
                foreach ($productsInStock as $stock) {
                    $stock->setStatus(Stock::STATUS_UNAVAILABLE);
                    $stock->setOrder($order);
                    $order->addStock($stock);
                }
            }
            $this->orderService->getRepository()->saveOrder($order);
            $_SESSION['product'] = [];
            return new HtmlResponse($this->template->render('product::product-order-success'));
        }
        return new RedirectResponse($this->router->generateUri("product", ['action' => 'checkout']));
    }
}