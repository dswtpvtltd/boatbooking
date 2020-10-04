<?php
namespace Dreamsunrise\Boatbooking\Controller\Boat;
 
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Helper\Image;
use Magento\Store\Model\StoreManager;
use Dreamsunrise\Boatbooking\Model\Session;

class Productlist extends \Magento\Framework\App\Action\Action
{  
   protected $productFactory;
   protected $imageHelper;
   protected $listProduct;
   protected $_storeManager;
   protected $_boatSession;
   
   public function __construct(
       \Magento\Framework\App\Action\Context $context,
       \Magento\Framework\Data\Form\FormKey $formKey,
       ProductFactory $productFactory,
       StoreManager $storeManager,
       Image $imageHelper,
       Session $boatSession    
   )
   {
       $this->_boatSession = $boatSession;
       $this->_productFactory = $productFactory;
       $this->imageHelper = $imageHelper;
       $this->_storeManager = $storeManager;
       parent::__construct($context);
   }
 
   public function getCollection()
   {
       return $this->productFactory->create()
           ->getCollection()
           ->addAttributeToSelect('*')
           ->setPageSize(5)
           ->setCurPage(1);
   }
 
   public function execute()
   {
       $productIds = $this->_boatSession->getBoatSession();
       
       $productData = [];
       $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
       $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
       $FormKey = $objectManager->get('Magento\Framework\Data\Form\FormKey'); 
       
        if(!empty($productIds['products'])):
            foreach($productIds['products'] as $_productIds):
                $product = $this->_productFactory->create()->load($_productIds);
                
                $productData[] = [
                        'entity_id' => $product->getId(),
                        'name'      => $product->getName(),
                        'price'     => '$' . $product->getPrice(),
                        'src'       => $this->imageHelper->init($product, 'product_base_image')->getUrl(),
                        'href'      => $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB)."boatbooking/boat/delete/product/".$product->getId()."/form_key/".$FormKey->getFormKey(),
                       ];
            endforeach;
        endif;
        
        echo json_encode($productData);
        return;
    }
}