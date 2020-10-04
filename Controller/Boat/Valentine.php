<?php
namespace Dreamsunrise\Boatbooking\Controller\Boat;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;

/**
 * Description of Index
 *
 * @author vidyasagar
 */
class Valentine extends Action
{
     protected $_storeManager;
     protected $_urlInterface;

     public function __construct(
         \Magento\Framework\App\Action\Context $context,
         \Magento\Store\Model\StoreManagerInterface $storeManager,
         \Magento\Framework\UrlInterface $urlInterface
     )
     {
         $this->_storeManager = $storeManager;
         $this->_urlInterface = $urlInterface;
         parent::__construct($context);
     }

     public function execute() {
        $resultRedirect = $this->resultRedirectFactory->create();

        $product = $this->getRequest()->getParam("product");

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $currentlink = $this->_storeManager->getStore()->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);

        $FormKey = $objectManager->get('Magento\Framework\Data\Form\FormKey');
        $link = $this->_storeManager->getStore()->getUrl('boatbooking/boat/add/product/'.$product."/form_key/".$FormKey->getFormKey()."/referer/".base64_encode($currentlink));
        return $resultRedirect->setPath($link);
     }
}
