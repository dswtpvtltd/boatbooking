<?php

namespace Dreamsunrise\Boatbooking\Controller\Boat;

use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Helper\Image;
use Magento\Store\Model\StoreManager;
use Dreamsunrise\Boatbooking\Model\Session;
use Magento\Framework\Mail\Template\TransportBuilder;
use Dreamsunrise\Boatbooking\Model\BoatFactory;
use Magento\Framework\Exception\LocalizedException;


use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Contact\Model\ConfigInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\Result\Redirect;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject;
use Magento\Framework\Translate\Inline\StateInterface;

class Save extends \Magento\Framework\App\Action\Action
{
    protected $productFactory;
    protected $imageHelper;
    protected $listProduct;
    protected $_storeManager;
    protected $_boatSession;
    protected $_formKeyValidator;
    protected $_boatFactory;
    protected $inlineTranslation;
    protected $_transportBuilder;
    protected $_logo;
    protected $_everttypeFactory;
    protected $_pricerangeFactory;
    protected $_escaper;
    protected $_realnameFactory;
    protected $_cookieManager;
    protected $_date;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        ProductFactory $productFactory,
        StoreManager $storeManager,
        StateInterface $inlineTranslation,
        TransportBuilder $transportBuilder,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        Image $imageHelper,
        \Magento\Theme\Block\Html\Header\Logo $logo,
        Session $boatSession,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        \Dreamsunrise\Eventtype\Model\EventtypeFactory $eventtypeFactory,
        \Dreamsunrise\Pricerange\Model\PricerangeFactory $pricerangeFactory,
        \Dreamsunrise\Boatowner\Model\RealnameFactory $realnameFactory,
        BoatFactory $boatFactory,
        \Magento\Framework\Escaper $escaper
    ) {
        $this->_formKeyValidator = $formKeyValidator;
        $this->inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_boatSession = $boatSession;
        $this->_logo = $logo;
        $this->_boatFactory = $boatFactory;
        $this->_productFactory = $productFactory;
        $this->imageHelper = $imageHelper;
        $this->_storeManager = $storeManager;
        $this->_everttypeFactory = $eventtypeFactory;
        $this->_pricerangeFactory = $pricerangeFactory;
        $this->_realnameFactory = $realnameFactory;
        $this->_escaper = $escaper;
        $this->_date = $date;
        $this->_cookieManager = $cookieManager;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            if (!$this->_formKeyValidator->validate($this->getRequest())) {
                return $this->resultRedirectFactory->create()->setPath('*/*/');
            }

            $data = $this->getRequest()->getPostValue();

            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();

            $productIds = $this->_boatSession->getBoatSession();

            if (empty($productIds['products'])) {
                return $resultRedirect->setPath('*/*/*/');
            }

            $enquirydata = array();

            if ($data) {
                $this->validatedParams();

                $score = 0;
                $realnameData = array();
                if (!empty($productIds['products'])) :
                    foreach ($productIds['products'] as $_productIds) :
                        $product = $this->_productFactory->create()->load($_productIds);
                        $productData[] = $product->getName();
                        if ($product->getRealname() != '') :
                            $realname = $this->_realnameFactory->create()->getCollection();
                            foreach ($realname as $_realname) {
                                if ($product->getRealname() == $_realname->getRealnameAttributeOptionId()) {
                                    $realnameData[] = $_realname->getRealname();
                                }
                            }
                        endif;
                    endforeach;
                endif;

                $model = $this->_boatFactory->create();

                $enquirydata['firstName'] = $data['firstname'];

                $firstname = $data['firstname'];

                $enquirydata['lastName'] = $data['lastname'];

                $lastname = $data['lastname'];

                $enquirydata['apistatus'] = 0;
                $enquirydata['companyName'] = $data['companyname'];

                if (!empty($data['remark'])) {
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
                $countryList[1] = 93;
                $countryList[2] = 355;
                $countryList[3] = 213;
                $countryList[4] = 1;
                $countryList[5] = 376;
                $countryList[6] = 244;
                $countryList[7] = 1;
                $countryList[8] = 672;
                $countryList[9] = 1;
                $countryList[10] = 54;
                $countryList[11] = 374;
                $countryList[12] = 297;
                $countryList[13] = 61;
                $countryList[14] = 43;
                $countryList[15] = 994;
                $countryList[16] = 1;
                $countryList[17] = 973;
                $countryList[18] = 880;
                $countryList[19] = 1;
                $countryList[20] = 375;
                $countryList[21] = 32;
                $countryList[22] = 501;
                $countryList[23] = 229;
                $countryList[24] = 1;
                $countryList[25] = 975;
                $countryList[26] = 591;
                $countryList[27] = 387;
                $countryList[28] = 267;
                $countryList[29] = 55;
                $countryList[30] = 246;
                $countryList[31] = 1;
                $countryList[32] = 673;
                $countryList[33] = 359;
                $countryList[34] = 226;
                $countryList[35] = 257;
                $countryList[36] = 855;
                $countryList[37] = 237;
                $countryList[38] = 1;

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
                $enquirydata['image'] = $this->_logo->getLogoSrc();
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

                foreach ($eventtype as $_eventtype) {
                    if ($enquirydata['custentity_event_type'] == $_eventtype->getEventtypeId()) {
                        $enquirydata['custentity_event_type'] = $_eventtype->getTitle();
                        $score += $_eventtype->getScore();
                    }
                }

                $enquirydata['custentity_est_start_time'] = $data['estimated_starttime'];
                $enquirydata['custentity_product_name_magento'] = $data['magento_lead_c'];

                $enquirydata['description'] = implode(",", $productData);
                $enquirydata['custentity_mgto_boat_rn'] = implode(",", $realnameData);

                $description = implode(",", $productData);

                $enquirydata['pricerange'] = $data['pricerange'];

                $pricerange = $this->_pricerangeFactory->create()->getCollection();

                foreach ($pricerange as $_pricerange) {
                    if ($enquirydata['pricerange'] == $_pricerange->getPricerangeId()) {
                        $enquirydata['pricerange'] = $_pricerange->getPricerangeId();
                        $score += $_pricerange->getScore();
                    }
                }

                $enquirydata['score'] = $score;
                $enquirydata['client_id'] = $this->_cookieManager->getCookie("anyboat");
                $enquirydata['traffic_id'] = $this->_cookieManager->getCookie("aw-affiliate-statistic");


                $model->setData($enquirydata);

                if ($model->save()) {
                    $msg = '';
                    $msg .= $firstname . ' ' . $lastname . "%0D%0A";
                    $msg .= $telephone . "%0D%0A";
                    $msg .= $enquirydata['custentity_event_type'] . "%0D%0A";
                    $msg .= $startdate . "%0D%0A";
                    $msg .= 'Min ' . $min_guests_c . " Max " . $max_guests_c . "%0D%0A";
                    $msg .= $description;

                    $Curl_Session =  curl_init("https://www.smsglobal.com/http-api.php");
                    curl_setopt($Curl_Session, CURLOPT_POST, true);

                    curl_setopt($Curl_Session, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($Curl_Session, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($Curl_Session);

                    curl_close($Curl_Session);

                    $templateOptions = array(
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    );

                    $from = array(

                        'name' => $this->_escaper->escapeHtml('Anyboat Enquiry')
                    );

                    $this->inlineTranslation->suspend();
                    $sentto = $enquirydata['email'];

                    $postObject = new \Magento\Framework\DataObject();
                    $postObject->setData($enquirydata);

                    $transport = $this->_transportBuilder
                        ->setTemplateIdentifier('boatbooking_boat_template')
                        ->setTemplateOptions($templateOptions)
                        ->setTemplateVars($enquirydata)
                        ->setFrom($from)
                        ->addTo($sentto)

                        ->setReplyTo($enquirydata['email'], $enquirydata['firstName'] . " " . $enquirydata['lastName'])
                        ->getTransport();

                    $transport->sendMessage();
                    $this->inlineTranslation->resume();
                }

                $this->messageManager->addSuccess(__(implode(",", $productData) . ' was added to your Quote Request.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                return $resultRedirect->setPath('*/*/success');
            }
        } catch (Exception $ex) {

            $this->messageManager->addError(__($ex->getMessage()));
            return $resultRedirect->setPath('boatbooking/boat');
        } catch (LocalizedException $e) {

            $this->messageManager->addError(__($e->getMessage()));
            return $resultRedirect->setPath('boatbooking/boat');
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function validatedParams()
    {
        $request = $this->getRequest();
        /*
       if (trim($request->getParam('firstname')) === '') {
           throw new LocalizedException(__('Enter the Name and try again.'));
       }

       if(!preg_match("/^([a-zA-Z' ]+)$/",$request->getParam('firstname'))){
           throw new LocalizedException(__('Enter the Name and try again.'));
       }

       if(!preg_match("/^([a-zA-Z' ]+)$/",$request->getParam('lastname'))){
           throw new LocalizedException(__('Enter the Name and try again.'));
       }
       */
        if (trim($request->getParam('remark')) === '') {
            throw new LocalizedException(__('Enter the comment and try again.'));
        }

        preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', trim($request->getParam('remark')), $match);

        if (count($match[0]) > 0) {
            throw new LocalizedException(__('Enter the comment and try again. Please do not use URL in comments.'));
        }

        if (false === strpos($request->getParam('email'), '@')) {
            throw new LocalizedException(__('The email address is invalid. Verify the email address and try again.'));
        }

        if ($this->checkdatef($request->getParam('startdate')) == 0) {
            throw new LocalizedException(__('Please enter the corerct booking date/time.'));
        }

        return $request->getParams();
    }

    public function checkdatef($cdate)
    {
        $cdate = str_replace('/', "-", $cdate);

        $now = $this->_date->date()->format('d-m-Y H:i:s');
        $date = $this->_date->date(new \DateTime($cdate . " 23:59:00"))->format('Y/m/d H:i:s');

        $now = $this->_date->date(new \DateTime($now))->format('Y/m/d H:i:s');

        if ($date < $now) {
            return 0;
        } else {
            return 1;
        }
    }
}
