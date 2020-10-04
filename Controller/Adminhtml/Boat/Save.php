<?php

namespace Dreamsunrise\Boatbooking\Controller\Adminhtml\Boat;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Backend\Helper\Js
     */
    protected $_jsHelper;

    /**
     * @var \Webspeaks\ProductsGrid\Model\ResourceModel\Contact\CollectionFactory
     */
    protected $_contactCollectionFactory;
    
    protected $_logger;

    protected $_attributeRepository;

    protected $_attributeOptionManagement;

    protected $_option;

    protected $_attributeOptionLabel;


    /**
     * \Magento\Backend\Helper\Js $jsHelper
     * @param Action\Context $context
     */
    public function __construct(
        Context $context,
        \Magento\Backend\Helper\Js $jsHelper,
        \Dreamsunrise\Boatbooking\Model\ResourceModel\Boat\CollectionFactory $contactCollectionFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Eav\Model\AttributeRepository $attributeRepository,
        \Magento\Eav\Api\AttributeOptionManagementInterface $attributeOptionManagement,
        \Magento\Eav\Api\Data\AttributeOptionLabelInterface $attributeOptionLabel,
        \Magento\Eav\Model\Entity\Attribute\Option $option
    ) {
        $this->_logger = $logger;
        $this->_attributeRepository = $attributeRepository;
        $this->_attributeOptionManagement = $attributeOptionManagement;
        $this->_option = $option;
        $this->_attributeOptionLabel = $attributeOptionLabel;
        
        $this->_jsHelper = $jsHelper;
        $this->_contactCollectionFactory = $contactCollectionFactory;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return true;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        
        if ($data) {

            /** @var \Webspeaks\ProductsGrid\Model\Contact $model */
            $model = $this->_objectManager->create('Dreamsunrise\Boatbooking\Model\Boat');

            $id = $this->getRequest()->getParam('enquiry_id');
            if ($id) {
                $model->load($id);
            }
            
            try {
                $model->setData($data['boatbooking']);
                $model->save();
                
                $this->messageManager->addSuccess(__('You saved this Boat Enquiry.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['enquiry_id' => $model->getEnquiryId(), '_current' => true]);
                }
                
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Boat Enquiry.'.$e->getMessage()));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['enquiry_id' => $this->getRequest()->getParam('enquiry_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
