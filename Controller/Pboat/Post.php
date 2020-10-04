<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Dreamsunrise\Boatbooking\Controller\Pboat;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Contact\Model\ConfigInterface;
use Magento\Contact\Model\MailInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Mail\Template\TransportBuilder;

class Post extends \Magento\Framework\App\Action\Action
{
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var Context
     */
    private $context;

    /**
     * @var MailInterface
     */
    private $mail;

    /**
     * @var LoggerInterface
     */
    private $logger;

    protected $_everttypeFactory;
    protected $_pricerangeFactory;
    protected $_boatFactory;
    protected $_escaper;
    protected $inlineTranslation;
    protected $_transportBuilder;
    protected $_date;

    public function __construct(
      \Magento\Framework\App\Action\Context $context,
      ConfigInterface $contactsConfig,
      MailInterface $mail,
      DataPersistorInterface $dataPersistor,
      LoggerInterface $logger = null,
      \Dreamsunrise\Eventtype\Model\EventtypeFactory $eventtypeFactory,
      \Dreamsunrise\Pricerange\Model\PricerangeFactory $pricerangeFactory,
      \Dreamsunrise\Boatbooking\Model\BoatFactory $boatFactory,
      \Magento\Framework\Escaper $escaper,
      StateInterface $inlineTranslation,
      \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
      TransportBuilder $transportBuilder
     ){
       $this->_everttypeFactory = $eventtypeFactory;
       $this->_pricerangeFactory = $pricerangeFactory;
       $this->_boatFactory = $boatFactory;
       $this->context = $context;
       $this->mail = $mail;
       $this->dataPersistor = $dataPersistor;
       $this->_escaper = $escaper;
       $this->_date = $date;
       $this->inlineTranslation = $inlineTranslation;
       $this->_transportBuilder = $transportBuilder;
       $this->logger = $logger ?: ObjectManager::getInstance()->get(LoggerInterface::class);
       parent::__construct($context);
      }

    /**
     * Post user question
     *
     * @return Redirect
     */
    public function execute()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        try {
            if($_SERVER['HTTP_X_REAL_IP'] == '144.48.170.94'){
              $this->validatedParams();
            }
            $data = $this->getRequest()->getPost();

            $model = $this->_boatFactory->create();

            $score = 0;

            $enquirydata['firstName'] = $data['firstname'];

            $firstname = $data['firstname'];

            $enquirydata['lastName'] = $data['lastname'];

            $lastname = $data['lastname'];

            $enquirydata['apistatus'] = 0;
            $enquirydata['companyName'] = $data['companyname'];

            if(!empty($data['remark'])){
               $enquirydata['comments'] = stripslashes($data['remark']);
            }


            $isdcodeList = array();
                $isdcodeList[1] = 2;
                $isdcodeList[2] = 2;
                $isdcodeList[3] = 8;
                $isdcodeList[4] = 7;
                $isdcodeList[5] = 8;
                $isdcodeList[6] = 3;
                $isdcodeList[7] = 3;
                $isdcodeList[8] = 8;

            $countryList = array();
            $countryList[1]=93;
            $countryList[2]=355;
            $countryList[3]=213;
            $countryList[4]=1;
            $countryList[5]=376;
            $countryList[6]=244;
            $countryList[7]=1;
            $countryList[8]=672;
            $countryList[9]=1;
            $countryList[10]=54;
            $countryList[11]=374;
            $countryList[12]=297;
            $countryList[13]=61;
            $countryList[14]=43;
            $countryList[15]=994;
            $countryList[16]=1;
            $countryList[17]=973;
            $countryList[18]=880;
            $countryList[19]=1;
            $countryList[20]=375;
            $countryList[21]=32;
            $countryList[22]=501;
            $countryList[23]=229;
            $countryList[24]=1;
            $countryList[25]=975;
            $countryList[26]=591;
            $countryList[27]=387;
            $countryList[28]=267;
            $countryList[29]=55;
            $countryList[30]=246;
            $countryList[31]=1;
            $countryList[32]=673;
            $countryList[33]=359;
            $countryList[34]=226;
            $countryList[35]=257;
            $countryList[36]=855;
            $countryList[37]=237;
            $countryList[38]=1;

            $enquirydata['phone'] = "+" . $countryList[$data['countrycode_mobile']] . $data['telephone'];
            $telephone = $countryList[$data['countrycode_mobile']] . $data['telephone'];
            $enquirydata['altPhone'] = "+" . $countryList[$data['countrycode_landline']] . $isdcodeList[$data['isdcode']] . $data['altphone'];
            
            //Landline (Number): 
            $enquirydata['custentity_ll_no'] = $data['altphone'];
            //Landline (Area Code): 
            $enquirydata['custentity_ll_ac'] = $data['isdcode'];
            //Landline (Country Code): 
            $enquirydata['custentity_ll_cc'] = $data['countrycode_landline'];
            //Mobile Phone (Number): 
            $enquirydata['custentity_mob_no'] = $data['telephone'];
            //Mobile Phone (Country Code): 
            $enquirydata['custentity_mob_cc'] = $data['countrycode_mobile'];

            
            $enquirydata['email'] = $data['email'];
            $enquirydata['status'] = 17;
            $enquirydata['image'] = '';
            $enquirydata['internalId'] = 17;
            $enquirydata['isPerson'] = 1;
            $enquirydata['custentity_min_no_of_guests'] = $data['min_guests_c'];

            $min_guests_c = $data['min_guests_c'];

            $enquirydata['custentity_max_no_of_guests'] = $data['max_guests_c'];

            $max_guests_c = $data['max_guests_c'];

            $enquirydata['custentity_2663_direct_debit'] = 1;
            $enquirydata['custentity_duration_type'] = $data['duration_type'];

            $durationtype = $data['duration_type'];

            $enquirydata['custentity_duration'] = $data['duration'];
            $enquirydata['custentity_lead_cruise_date'] = $data['startdate'];

            $startdate = $data['startdate'];

            $enquirydata['custentity_number_person'] = 1;
            $enquirydata['custentity_how_did_you_hear_about_us'] = $data['howyouhear'];

            $enquirydata['custentity_event_type'] = $data['eventtype'];

            $eventtype = $this->_everttypeFactory->create()->getCollection();

            foreach($eventtype as $_eventtype){
                if($enquirydata['custentity_event_type'] == $_eventtype->getEventtypeId()){
                   $enquirydata['custentity_event_type'] = $_eventtype->getTitle();
                   $score += $_eventtype->getScore();
                }
            }

            $enquirydata['custentity_est_start_time'] = $data['estimated_starttime'];
            $enquirydata['custentity_product_name_magento'] = $data['magento_lead_c'];

            $enquirydata['description'] = '';

            $description = '';

            $enquirydata['pricerange'] = $data['pricerange'];

            $pricerange = $this->_pricerangeFactory->create()->getCollection();

            foreach($pricerange as $_pricerange){
                if($enquirydata['pricerange'] == $_pricerange->getPricerangeId()){
                   $enquirydata['pricerange'] = $_pricerange->getPricerangeId();
                    $score += $_pricerange->getScore();
                }
            }

            $enquirydata['score'] = $score;

            $model->setData($enquirydata);

            if($model->save()){}

            $this->messageManager->addSuccessMessage(
                __('Thanks for contacting us with your comments and questions. We\'ll respond to you very soon.')
            );
            return $this->resultRedirectFactory->create()->setPath('boatbooking/pboat');
            $this->dataPersistor->clear('contact_us');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (Exception $ex) {
            $this->messageManager->addErrorMessage(__('An error occurred while processing your form. Please try again later.'));
        }
        return $this->resultRedirectFactory->create()->setPath('boatbooking/pboat');
    }

    /**
     * @param array $post Post data from contact form
     * @return void
     */
    private function sendEmail($post)
    {
        $this->mail->send(
            $post['email'],
            ['data' => new DataObject($post)]
        );
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function validatedParams()
    {
        $request = $this->getRequest();
        if (trim($request->getParam('firstname')) === '') {
            throw new LocalizedException(__('Enter the Name and try again.'));
        }

        if(!preg_match("/^([a-zA-Z' ]+)$/",trim($request->getParam('firstname')))){
            throw new LocalizedException(__('Enter the Name and try again.'));
        }

        if(!preg_match("/^([a-zA-Z' ]+)$/",trim($request->getParam('lastname')))){
            throw new LocalizedException(__('Enter the Name and try again.'));
        }

        if (trim($request->getParam('remark')) === '') {
            throw new LocalizedException(__('Enter the comment and try again.'));
        }

        preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', trim($request->getParam('remark')), $match);

        if(count($match[0]) > 0)
        {
           throw new LocalizedException(__('Enter the comment and try again. Please do not use URL in comments.'));
        }

        if (false === strpos($request->getParam('email'), '@')) {
            throw new LocalizedException(__('The email address is invalid. Verify the email address and try again.'));
        }

        if($this->checkdatef($request->getParam('startdate')) == 0){
          throw new LocalizedException(__('Please enter the corerct booking date/time.'));
        }

        return $request->getParams();
    }

    public function checkdatef($cdate)
    {
        $cdate = str_replace('/',"-",$cdate);

        $now = $this->_date->date()->format('d-m-Y H:i:s');
        $date = $this->_date->date(new \DateTime($cdate." 23:59:00"))->format('Y/m/d H:i:s');

        $now = $this->_date->date(new \DateTime($now))->format('Y/m/d H:i:s');

        if($date < $now) {
            return 0;
        }else{
            return 1;
        }
    }
}
