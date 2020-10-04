<?php
namespace Dreamsunrise\Boatbooking\Controller\Boat;
 
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Helper\Image;
use Magento\Store\Model\StoreManager;
use Dreamsunrise\Boatbooking\Model\Session;

class Delete extends \Magento\Framework\App\Action\Action
{  
   protected $productFactory;
   protected $imageHelper;
   protected $listProduct;
   protected $_storeManager;
   protected $_boatSession;
   protected $_formKeyValidator;
   
   public function __construct(
       \Magento\Framework\App\Action\Context $context,
       \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,    
       ProductFactory $productFactory,
       StoreManager $storeManager,
       Image $imageHelper,
       Session $boatSession    
   )
   {
       $this->_boatSession = $boatSession;
       $this->_productFactory = $productFactory;
       $this->imageHelper = $imageHelper;
       $this->_formKeyValidator = $formKeyValidator;
       $this->_storeManager = $storeManager;
       parent::__construct($context);
   }
 
   public function execute()
   {
       if (!$this->_formKeyValidator->validate($this->getRequest())) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }
       
       if ($id = (int)$this->getRequest()->getParam('product')) {
           $productIds = $this->_boatSession->getBoatSession();
           unset($productIds['products'][$id]);
           $this->_boatSession->setBoatSession($productIds);
           return $this->resultRedirectFactory->create()->setPath('*/*/');
        }
    }
}