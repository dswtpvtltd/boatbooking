<?php
namespace Dreamsunrise\Boatbooking\Controller\Pboat;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use Dreamsunrise\Boatbooking\Model\BoatFactory;
use Psr\Log\LoggerInterface;

/**
 * Description of Index
 *
 * @author vidyasagar
 */
class Index extends Action
{
    protected $logger;
    protected $boat;
    protected $_date;
    protected $_affiliatestaticticsFactory;

    public function __construct(
            \Magento\Framework\App\Action\Context $context,
            LoggerInterface $logger,
            BoatFactory $boat,
            \Dreamsunrise\Visitorcookies\Model\AffiliatestaticticsFactory $affiliatestaticticsFactory,
            \Magento\Framework\Stdlib\DateTime\DateTime $_date
            )
    {
      $this->logger = $logger;
      $this->boat = $boat;
      $this->_affiliatestaticticsFactory = $affiliatestaticticsFactory;
      $this->_date = $_date;
      parent::__construct($context);
    }

    /**
    * Write to system.log
    *
    * @return void
    */

  public function execute() {
    /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
    $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    $resultPage->getConfig()->getTitle()->prepend(__('Boat Enquiry'));

    return $resultPage;
  }
}
