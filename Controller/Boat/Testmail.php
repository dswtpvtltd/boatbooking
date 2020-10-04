<?php
namespace Dreamsunrise\Boatbooking\Controller\Boat;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use Psr\Log\LoggerInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Helper\Image;
use Magento\Store\Model\StoreManager;
use Dreamsunrise\Boatbooking\Model\Session;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Dreamsunrise\Boatbooking\Model\BoatFactory;

/**
 * Description of Index
 *
 * @author vidyasagar
 */
class Testmail extends Action
{
    protected $logger;
    protected $inlineTranslation;
    protected $_transportBuilder;
    protected $_storeManager;
    protected $_escaper;
    protected $_boat;
    protected $temp_id;

    public function __construct(
            \Magento\Framework\App\Action\Context $context,
            LoggerInterface $logger,
            StoreManager $storeManager,
            StateInterface $inlineTranslation,
            TransportBuilder $transportBuilder,
            BoatFactory $boat,
            \Magento\Framework\Escaper $escaper
        )
    {
      $this->_boat = $boat;
      $this->inlineTranslation = $inlineTranslation;
      $this->_transportBuilder = $transportBuilder;
      $this->_escaper = $escaper;
      $this->_storeManager = $storeManager;
      parent::__construct($context);
    }

    /**
    * Write to system.log
    *
    * @return void
    */

  public function execute() {
    ini_set('display_startup_errors', true);
    error_reporting(E_ALL);
    ini_set('display_errors', true);
    $boat = $this->_boat->create()
            ->getCollection()
            ->addFieldToFilter("apistatus",0);

    $boat->getSelect()->limit(1);

    $curldata = array();

    $rows = $boat->getData();

    if(!empty($rows[0])){
        $enquirydata = $rows[0];

        $from = array(
          'email' => $this->_escaper->escapeHtml("boat@anyboat.com.au"),
          'name' => $this->_escaper->escapeHtml('Anyboat Enquiry')
        );

        $this->inlineTranslation->suspend();
        $sentto = $enquirydata['email'];

        $postObject = new \Magento\Framework\DataObject();
        $postObject->setData($enquirydata);

        try{
          $transport = $this->_transportBuilder
                        ->setTemplateIdentifier('boatbooking_boat_template')
                        ->setTemplateOptions([
                          'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                          'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID
                        ])
                        ->setTemplateVars($enquirydata)
                        ->setFrom($from)
                        ->addTo($sentto)
                        ->setReplyTo($enquirydata['email'], $enquirydata['firstName'] . " " .$enquirydata['lastName'])
                        ->getTransport();

          $transport->sendMessage();
          $this->inlineTranslation->resume();

        }catch(Exception $e){
          echo $e->getMessage();
        }
    }
  }
}
