<?php
namespace Dreamsunrise\Boatbooking\Controller\Adminhtml\Boat;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Dreamsunrise\Boatbooking\Model\ResourceModel\Boat\Collection;
use Dreamsunrise\Boatbooking\Model\ResourceModel\Boat\CollectionFactory;

class MassDelete extends \Magento\Backend\App\Action
{
    protected $filter;
    protected $collectionFactory;
    
    public function __construct(Context $context, 
                                Filter $filter, 
                                CollectionFactory $collectionFactory
                               )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $ids = $this->getRequest()->getParam('selected');
        $collectionSize = 0;
        
        foreach($ids as $_ids){
            $model = $this->_objectManager->create('Dreamsunrise\Boatbooking\Model\Boat');
            $model->load($_ids);
            
            $model->delete();
            $collectionSize++;
        }
        
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('boatbooking/boat/index');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dreansunrise_Boatbooking::delete_boat');
    }
}
