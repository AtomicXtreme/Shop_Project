<?php
declare(strict_types=1);

namespace Frontend\Product\Controller;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Dot\Controller\AbstractActionController;
use Dot\FlashMessenger\FlashMessenger;
use Frontend\App\Plugin\FormsPlugin;
use Frontend\Product\Entity\Product;
use Frontend\Product\Form\ProductForm;
use Frontend\Product\Form\StockForm;
use Frontend\Product\FormData\ProductFormData;
use Frontend\Product\InputFilter\ProductInputFilter;
use Frontend\Product\InputFilter\StockInputFilter;
use Frontend\Product\Service\CategoryService;
use Frontend\Product\Service\OrderService;
use Frontend\Product\Service\StockService;
use Frontend\User\Form\UserForm;
use Frontend\Product\Service\ProductService;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\AuthenticationServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ProductController extends AbstractActionController
{
    protected RouterInterface $router;

    protected TemplateRendererInterface $template;

    protected ProductService $productService;

    protected CategoryService $categoryService;

    protected StockService $stockService;

    protected OrderService $orderService;

    protected AuthenticationServiceInterface $authenticationService;

    protected FlashMessenger $messenger;

    protected FormsPlugin $forms;

    protected ProductForm $productForm;

    protected StockForm $stockForm;


    public function __construct(
        ProductService            $productService,
        CategoryService           $categoryService,
        StockService              $stockService,
        OrderService              $orderService,
        RouterInterface           $router,
        TemplateRendererInterface $template,
        AuthenticationService     $authenticationService,
        FlashMessenger            $messenger,
        FormsPlugin               $forms,
        ProductForm               $productForm,
        StockForm                 $stockForm
    )
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->stockService = $stockService;
        $this->orderService = $orderService;
        $this->router = $router;
        $this->template = $template;
        $this->authenticationService = $authenticationService;
        $this->messenger = $messenger;
        $this->forms = $forms;
        $this->productForm = $productForm;
        $this->stockForm = $stockForm;
    }

    /**
     * Render product table
     * @return ResponseInterface
     */
    public function manageProductsAction(): ResponseInterface
    {
        return new HtmlResponse($this->template->render('product::list'));
    }

    /**
     * Render order table
     * @return ResponseInterface
     */
    public function manageOrdersAction(): ResponseInterface
    {
        return new HtmlResponse($this->template->render('product::order'));
    }

    /**
     * Generate data that is displayed inside product table
     * @return ResponseInterface
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function listProductsAction(): ResponseInterface
    {

        $params = $this->getRequest()->getQueryParams();
        $search = (!empty($params['search'])) ? $params['search'] : null;
        $sort = (!empty($params['sort'])) ? $params['sort'] : "created";
        $order = (!empty($params['order'])) ? $params['order'] : "desc";
        $offset = (!empty($params['offset'])) ? (int)$params['offset'] : 0;
        $limit = (!empty($params['limit'])) ? (int)$params['limit'] : 30;

        $result = $this->productService->getProducts($offset, $limit, $search, $sort, $order);
        return new JsonResponse($result);
    }

    /**
     * Generate data that is displayed inside order table
     * @return ResponseInterface
     */
    public function listOrdersAction(): ResponseInterface
    {

        $params = $this->getRequest()->getQueryParams();

        $sort = (!empty($params['sort'])) ? $params['sort'] : "created";
        $order = (!empty($params['order'])) ? $params['order'] : "desc";
        $offset = (!empty($params['offset'])) ? (int)$params['offset'] : 0;
        $limit = (!empty($params['limit'])) ? (int)$params['limit'] : 30;

        $result = $this->orderService->getOrders($offset, $limit, $sort, $order);
        return new JsonResponse($result);
    }

    /**
     * Add product function
     * @return ResponseInterface
     */
    public function addAction(): ResponseInterface
    {

        $request = $this->request;

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $this->productForm->setData($data);
            if ($this->productForm->isValid()) {
                $result = $this->productForm->getData();
                try {
                    $this->productService->createProduct($result);
                    return new JsonResponse(['success' => 'success', 'message' => 'Product created successfully']);
                } catch (Throwable $e) {
                    return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                return new JsonResponse(
                    [
                        'success' => 'error',
                        'message' => $this->forms->getMessagesAsString($this->productForm)
                    ]
                );
            }
        }

        return new HtmlResponse(
            $this->template->render(
                'partial::ajax-form',
                [
                    'form' => $this->productForm,
                    'formAction' => '/product/add'
                ]
            )
        );
    }

    /**
     * Edit/Update product function
     * @return ResponseInterface
     * @throws NonUniqueResultException
     */
    public function editAction(): ResponseInterface
    {

        $request = $this->getRequest();
        $uuid = $request->getAttribute('uuid');
        $product = $this->productService->getRepository()->find($uuid);
//        var_dump($product);
//        exit("aa");
        $formData = new ProductFormData();
        $formData->fromEntity($product);
//        var_dump($formData);
//        exit("aa");
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $this->productForm->setData($data);
            $this->productForm->setInputFilter(new ProductInputFilter());
            if ($this->productForm->isValid()) {
                $result = $this->productForm->getData();
                try {
                    $this->productService->updateProduct($product, $result);
                    return new JsonResponse(['success' => 'success', 'message' => 'Product updated successfully']);
                } catch (Throwable $e) {
                    return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                return new JsonResponse(
                    [
                        'success' => 'error',
                        'message' => $this->forms->getMessagesAsString($this->productForm)
                    ]
                );
            }
        }

        $this->productForm->bind($formData);

        return new HtmlResponse(
            $this->template->render(
                'partial::ajax-form',
                [
                    'form' => $this->productForm,
                    'formAction' => '/product/edit/' . $uuid
                ]
            )
        );
    }

    /**
     * Delete product function
     * @return ResponseInterface
     * @throws NonUniqueResultException
     */
    public function deleteAction(): ResponseInterface
    {
        $request = $this->getRequest();
        $data = $request->getParsedBody();

        if (!empty($data['uuid'])) {
            $product = $this->productService->getRepository()->find($data['uuid']);
        } else {
            return new JsonResponse(['success' => 'error', 'message' => 'Could not find product']);
        }

        try {
            $product->setStatus(Product::STATUS_UNAVAILABLE);

            $this->productService->getRepository()->saveProduct($product);
            return new JsonResponse(['success' => 'success', 'message' => 'Product Deleted Successfully']);
        } catch (Throwable $e) {
            return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Add specified stock for a specific product
     * @return ResponseInterface
     * @throws NonUniqueResultException
     */
    public function stockAction(): ResponseInterface
    {
        $request = $this->getRequest();
        $uuid = $request->getAttribute('uuid');
        $product = $this->productService->getRepository()->find($uuid);
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();
            $this->stockForm->setData($data);
            $this->stockForm->setInputFilter(new StockInputFilter());
            if ($this->stockForm->isValid()) {
                $result = $this->stockForm->getData();
//                var_dump($result);
//                exit("test");
                try {
                    $this->stockService->createStock($product, (int)$result['nr']);
                    return new JsonResponse(['success' => 'success', 'message' => 'Product updated successfully']);
                } catch (Throwable $e) {
                    return new JsonResponse(['success' => 'error', 'message' => $e->getMessage()]);
                }
            } else {
                return new JsonResponse(
                    [
                        'success' => 'error',
                        'message' => $this->forms->getMessagesAsString($this->stockForm)
                    ]
                );
            }
        }

        return new HtmlResponse(
            $this->template->render(
                'partial::ajax-form',
                [
                    'form' => $this->stockForm,
                    'formAction' => '/product/stock/' . $uuid
                ]
            )
        );
    }
}