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
class Index extends Action
{
    public function execute() {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Boat Enquiry'));

        return $resultPage;
    }

    /**
     * Check Owner List Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dreamsunrise_Boatbooking::boatbooking');
    }

}
