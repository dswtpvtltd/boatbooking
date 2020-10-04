<?php

namespace Dreamsunrise\Boatbooking\Controller\Adminhtml\Boat;

use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;

class Delete extends Action
{

    /**
     * {@inheritdoc}
     */
    /*protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dreamsunrise_Boatowner::realname');
    }*/

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('enquiry_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('Dreamsunrise\Boatbooking\Model\Boat');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The Boat Booking has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['owner_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a Boat Booking to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
