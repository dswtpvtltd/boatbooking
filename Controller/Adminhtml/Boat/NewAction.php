<?php
namespace Dreamsunrise\Boatbooking\Controller\Adminhtml\Boat;

use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\App\Action\Context;

class NewAction extends \Magento\Backend\App\Action
{
    /**
     * Result page factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;
    
    
    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param OwnerFactory $ownerFactory
     */
    public function __construct(
         Context $context,
         ForwardFactory $resultForwardFactory,
         array $data = []
    ) {
       parent::__construct($context);
       $this->resultForwardFactory = $resultForwardFactory;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return true;
        // return $this->_authorization->isAllowed('Webspeaks_Contact::attachment_save');
    }

    /**
     * Forward to edit
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
