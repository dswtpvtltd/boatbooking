<?php
namespace Dreamsunrise\Boatbooking\Block;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\Template;
use Dreamsunrise\Boatbooking\Model\Session;
use Magento\Catalog\Model\ProductFactory;
use Magento\Backend\Model\View\Result\Redirect;

class Boatbooking extends Template
{
    public $_boatSession;
    protected $_productFactory;
    protected $imageHelper;
    protected $resultRedirectFactory;
    
    /**
    * @var \Magento\Framework\Filesystem
    */
    protected $_filesystem;
    protected $layoutProcessors;
    
    protected $_everttypeFactory;
    protected $_pricerangeFactory;
  
    /**
    * Lists constructor.
    * @param \Magento\Framework\View\Element\Template\Context $context
    * @param array $layoutProcessors
    * @param array $data
    */
    
    public function __construct(
         Context $context,
         Session $boatSession,
         ProductFactory $productFactory,
         \Magento\Framework\Filesystem $filesystem, 
         Redirect $resultRedirect,
         \Dreamsunrise\Eventtype\Model\EventtypeFactory $eventtypeFactory,
         \Dreamsunrise\Pricerange\Model\PricerangeFactory $pricerangeFactory,
         array $layoutProcessors = [],
         array $data = []
    ) {
        $this->resultRedirectFactory = $resultRedirect;
        $this->_productFactory = $productFactory;
        $this->_filesystem = $filesystem;
        $this->layoutProcessors = $layoutProcessors; 
        $this->jsLayout = isset($data['jsLayout']) && is_array($data['jsLayout']) ? $data['jsLayout'] : [];
        $this->_everttypeFactory = $eventtypeFactory;
        $this->_pricerangeFactory = $pricerangeFactory;
        $this->_boatSession = $boatSession;
        parent::__construct($context,$data);
    }
    
    public function getFormAction()
    {
        return $this->getUrl("boatbooking/boat/save", ["_secure" => true]);
    }

    
    public function getPriceRange(){
        return $this->_pricerangeFactory->create()->getCollection();
    }
    
    public function getEventType()
    {
       return $this->_everttypeFactory->create()->getCollection();
    }

    public function getJsLayout()
    {
        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }
        return \Zend_Json::encode($this->jsLayout);
    }

    public function getCacheLifetime()
    {
        return null;
    }
}
