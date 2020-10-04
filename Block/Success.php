<?php
namespace Dreamsunrise\Boatbooking\Block;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\Template;

class Success extends Template
{   
    /**
    * Lists constructor.
    * @param \Magento\Framework\View\Element\Template\Context $context
    * @param array $layoutProcessors
    * @param array $data
    */
    
    public function __construct(
         Context $context,
         array $data = []
    ) {
        parent::__construct($context,$data);
    }
}
