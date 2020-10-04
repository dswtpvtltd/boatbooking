<?php
namespace Dreamsunrise\Boatbooking\Controller\Boat;

use Magento\Framework\App\Action\Action;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Dreamsunrise\Boatbooking\Model\Session;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Add extends Action
{
    protected $_formKeyValidator;
    protected $_boatSession;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    public function __construct(
            \Magento\Framework\App\Action\Context $context,
            \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
            ProductRepositoryInterface $productRepository,
            Session $boatSession
            )
    {
        $this->_boatSession = $boatSession;
        $this->productRepository = $productRepository;
        $this->_formKeyValidator = $formKeyValidator;
        parent::__construct($context);
    }

    /**
     * Add product to shopping cart action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();

        try {
            $sessionboat = $this->_boatSession->getBoatSession();

            if(count($sessionboat['products']) == 0){
                $sessionboat['products'][$params['product']] = $params['product'];
            }else{
                $sessionboat['products'][$params['product']] = $params['product'];
            }
            //print_r($sessionboat);
            //$this->_boatSession->setBoatSession($sessionboat);
            //die;
            $this->_boatSession->setBoatSession($sessionboat);
            return $this->resultRedirectFactory->create()->setPath("boatbooking/boat");
        }
        catch (\Exception $e) {
            $this->messageManager->addException($e, __('We can\'t add this item to your Enquery right now.'));
            $this->_objectManager->get(\Psr\Log\LoggerInterface::class)->critical($e);
            $this->goBack();
        }
    }


    /**
     * Initialize product instance from request data
     *
     * @return \Magento\Catalog\Model\Product|false
     */
    protected function _initProduct()
    {
        $productId = (int)$this->getRequest()->getParam('product');
        if ($productId) {
            $storeId = $this->_objectManager->get(
                \Magento\Store\Model\StoreManagerInterface::class
            )->getStore()->getId();
            try {
                return $this->productRepository->getById($productId, false, $storeId);
            } catch (NoSuchEntityException $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * Resolve response
     *
     * @param string $backUrl
     * @param \Magento\Catalog\Model\Product $product
     * @return $this|\Magento\Framework\Controller\Result\Redirect
     */
    protected function goBack()
    {
        $referer = $this->getRequest()->getParam('referer');
        return $this->_url->getUrl(base64_decode($referer), ['_secure' => true]);
    }

    /**
     * @return string
     */
    private function getBoatUrl()
    {
        return $this->_url->getUrl('boatbooking/boat', ['_secure' => true]);
    }

}
