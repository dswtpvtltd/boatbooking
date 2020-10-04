<?php
namespace Dreamsunrise\Boatbooking\Block;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\Template;

class Pboat extends Template
{
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
         \Dreamsunrise\Eventtype\Model\EventtypeFactory $eventtypeFactory,
         \Dreamsunrise\Pricerange\Model\PricerangeFactory $pricerangeFactory,
         array $data = []
    ) {
        $this->_everttypeFactory = $eventtypeFactory;
        $this->_pricerangeFactory = $pricerangeFactory;
        parent::__construct($context,$data);
    }

    /**
     * Returns action url for contact form
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('boatbooking/pboat/post', ['_secure' => true]);
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
}
