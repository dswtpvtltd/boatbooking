<?php
namespace Dreamsunrise\Boatbooking\Controller\Adminhtml\Boat;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Dreamsunrise\Boatbooking\Model\ResourceModel\Boat\CollectionFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;

class Edit extends Action
{
    /**
     * @var \Magento\Backend\Model\View\Result\Forward
     */
    protected $resultForwardFactory;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Result page factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * News model factory
     *
     * @var \Tutorial\SimpleNews\Model\NewsFactory
     */
    protected $_ownerFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param OwnerFactory $ownerFactory
     */
    
    public function __construct(
         Context $context,
         Registry $coreRegistry,   
         PageFactory $resultPageFactory,
         CollectionFactory $ownerFactory,
         ForwardFactory $resultForwardFactory,
         array $data = []
    ) {
       parent::__construct($context);
       $this->_coreRegistry = $coreRegistry;
       $this->_resultPageFactory = $resultPageFactory;
       $this->resultForwardFactory = $resultForwardFactory;
       $this->_ownerFactory = $ownerFactory;
    }
    
    public function execute()
    {
        $id = $this->getRequest()->getParam('enquiry_id');
        
        /** @var \Dreamsunrise\Boatowner\Model\Owner $model */
        $model = $this->_objectManager->create("\Dreamsunrise\Boatbooking\Model\Boat");

        if ($id) {
            $model->load($id);
            
            if (!$model->getEnquiryId()) {
                $this->messageManager->addError(__('This post no longer exists.'));
                $this->_redirect('boatbooking/boat/index');
                return;
            }
        }
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
        
        $this->_coreRegistry->register('current_boatbooking', $model);
        
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Dreamsunrise_Boatbooking::main_menu');
        if($model->getName() != ''){
            $resultPage->getConfig()->getTitle()->prepend(__($model->getFirstName() . " ". $model->getLastName()));
        }else{
            $resultPage->getConfig()->getTitle()->prepend(__("Add New Boat Booking"));
        }
        
        
        
        $this->_view->getLayout()->getBlock('boatbooking_edit');
        $this->_view->renderLayout();
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dreamsunrise_Boatbooking::edit_boatbooking');
    }
}
