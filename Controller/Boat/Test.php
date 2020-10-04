<?php
namespace Dreamsunrise\Boatbooking\Controller\Boat;

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
class Test extends Action
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
    $boat = $this->boat->create()
            ->getCollection()
            ->addFieldToFilter("apistatus",0);

    $boat->getSelect()->limit(1);

    $curldata = array();

    $rows = $boat->getData();

    if(!empty($rows[0])){
        $id                  = $rows[0]['enquiry_id'];
        $curldata['firstname']            = $rows[0]["firstName"];
        $curldata['lastname']             = $rows[0]['lastName'];
        $companyname                      = $rows[0]['companyName'];
        $curldata['remark']               = $rows[0]['comments'];
        $curldata['phone']            = $rows[0]['phone'];

        //Landline (Number): 
        $curldata['custentity_ll_no'] = $rows[0]['custentity_ll_no'];
        //Landline (Area Code): 
        $curldata['custentity_ll_ac'] = $rows[0]['custentity_ll_ac'];
        //Landline (Country Code): 
        $curldata['custentity_ll_cc'] = $rows[0]['custentity_ll_cc'];
        //Mobile Phone (Number): 
        $curldata['custentity_mob_no'] = $rows[0]['custentity_mob_no'];
        //Mobile Phone (Country Code): 
        $curldata['custentity_mob_cc'] = $rows[0]['custentity_mob_cc'];

        $curldata['email']                = $rows[0]['email'];
        $curldata['custentity_number_person']                = $rows[0]['custentity_number_person'];

        $curldata['custentity_min_no_of_guests_formattedValue'] = $rows[0]['custentity_min_no_of_guests'];
        $curldata['custentity_min_no_of_guests']         = $rows[0]['custentity_min_no_of_guests'];

        $curldata['custentity_max_no_of_guests_formattedValue'] = $rows[0]['custentity_max_no_of_guests'];
        $curldata['custentity_max_no_of_guests']         = $rows[0]['custentity_max_no_of_guests'];

        $durationtype = array(
                                'Hours' => 1,
                                'Days' => 2,
                               );

        $durationtypevalues = '';

         foreach($durationtype as $key => $values){
              if($key == $rows[0]['custentity_duration_type']){
                 $durationtypevalues = $values;
              }
         }

        $curldata['custentity_duration_type']        = $durationtypevalues;
        $curldata['custentity_duration_formattedValue'] = $rows[0]['custentity_duration'];

        $curldata['custentity_duration']             = $rows[0]['custentity_duration'];
        $curldata['custentity_mgto_boat_rn']             = $rows[0]['custentity_mgto_boat_rn'];
        $curldata['custentity_lead_cruise_date']           = str_replace("_","0",$rows[0]['custentity_lead_cruise_date']);

        $Howyouheardata = array(
                                    'Past Customer' => 1,
                                    'Word Of Mouth' => 2,
                                    'Google' => 3,
                                    'Other Search Engine' => 4,
                                    'Magazine' => 5,
                                    'Newspaper' => 6,
                                    'Television' => 7,
                                    'Radio' => 8,
                                    'Other' => 9,
                                   );
        $Howyouhearvalues = '';

         foreach($Howyouheardata as $key => $values){
              if($key == $rows[0]['custentity_how_did_you_hear_about_us']){
                 $Howyouhearvalues = $values;
              }
         }


        $curldata['custentity_how_did_you_hear_about_us']           = $Howyouhearvalues;


        $eventtypedata = array(
                          'Christmas Cruise' => 1,
                          'Christmas Cruises' => 1,
                          'Fishing'=>2,
                          'Fishing Charter' => 2,
                          'New Years Day Cruises' => 3,
                          'New Years Eve Cruises' => 4,
                          'Australia Day Cruises' => 5,
                          'Boxing Day Cruises' => 6,
                          'Bucks Cruise' => 7,
                          'Hens Cruise' => 8,
                          'Overnight Luxury Charter' => 9,
                          'Party Boats' => 10,
                          'Private Harbour Cruises' => 11,
                          'Sailing' => 12,
                          'School Formals' => 13,
                          'Super Yachts' => 14,
                          'Team Building' => 15,
                          'Transfers' => 16,
                          'University Parties' => 17,
                          'Weddings' => 18,
                          'Whale Watching' => 19,
                          'Corporate Events' => 20,
                          'Other' => 21,
                          'Birthday Cruise' => 22,
                          'Vivid Cruise' => 23,
                          'Proposal' => 24,
                          'Harbour Life' => 25,
                          'Family Cruise' => 26,
                          'Production Company' => 27,
                          'Chinese New Year' => 28,
                          'Valentines Day Cruise' => 29
                      );

        $eventtypevalue = '';
        $eventtypeinternalId = '';

        foreach($eventtypedata as $key1 => $values1){
             if(trim($key1) == trim($rows[0]['custentity_event_type'])){
                $eventtypevalue = $key1;
                $eventtypeinternalId = $values1;
             }
        }

        $curldata['custentity_event_type']                 = $eventtypeinternalId;
        $curldata['custentity_est_start_time']             = str_replace("_","0",$rows[0]['custentity_est_start_time']);
        $curldata['custentity_product_name_magento']       = $rows[0]['custentity_product_name_magento'];
        $curldata['comments']                              = $rows[0]['description'];
        $curldata['pricerange']                            = $rows[0]['pricerange'];

        $this->add_leads($id,$curldata);

        //Order placed type
        $client_id = $rows[0]['client_id'];

        if($client_id != 0){
          $affiliatestaticticslists = $this->_affiliatestaticticsFactory
                                                   ->create()
                                                   ->getCollection()
                                                   ->addFieldToFilter("client_id",$client_id);
          foreach($affiliatestaticticslists as $_affiliatestaticticslist){
            $data = array();
            $clientid = $_affiliatestaticticslist->getClientId();
            $data['enquiry_id']     = $id;
            $hitid = $_affiliatestaticticslist->getHitId();
            $data['affiliate_id']     = $_affiliatestaticticslist->getAccountId();
            $data['campaign_id']    = $_affiliatestaticticslist->getCampaignId();
            $data['traffic_source'] = $_affiliatestaticticslist->getTrafficSource();
            $ordercount = $_affiliatestaticticslist->getOrdersCount();
            //$data['traffic_type'] = "enquiry";
            
            if($clientid == $client_id){
              $model = $this->boat->create()->load($id);
              $model->setData($data);
              $model->save();

              if($hitid != ''){
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
                $connection = $resource->getConnection();
                $tableName = $resource->getTableName('aw_aff_link_statistics'); //gives table name with
                
                //Update Data into table
                $sql = "update " . $tableName . " set traffic_type = 'enquiry', orders_count=" . ($ordercount + 1) . " where hit_id=" . $hitid;
                $connection->query($sql);
              }
            }
          }
        }
    }
  }
  public function add_leads($id,$curldata)
  {
      $boat = $this->boat->create()->load($id);
      $boat->setRuntime($this->_date->gmtDate());
      $boat->save();

      if(!empty($curldata)){
        $post_data = $curldata;

        /*new anyboat code*/
        $curl_connection = curl_init("https://4989106.extforms.netsuite.com/app/site/crm/externalleadpage.nl?compid=4989106");

        if(empty($curldata['comments'])){
            $curldata['comments'] = "From Anyboat Contact us page";
        }

        //custentity_ll_no=" . $curldata['custentity_ll_no'] . "&custentity_ll_ac=" . str_replace("+","", $curldata['custentity_ll_ac']) . "&custentity_ll_cc=" . $curldata['custentity_ll_cc'] . "&custentity_mob_no=" . $curldata['custentity_mob_no'] . "&custentity_mob_cc=" . str_replace("+","",$curldata['custentity_mob_cc']) . "&custentity_mgto_enq_num=" . $id . "&
        //update boatbooking set apistatus=0 where enquiry_id=5213;
        $post_string = "custentity_ll_no=" . $curldata['custentity_ll_no'] . "&custentity_ll_ac=" . str_replace("+","", $curldata['custentity_ll_ac']) . "&custentity_ll_cc=" . $curldata['custentity_ll_cc'] . "&custentity_mob_no=" . $curldata['custentity_mob_no'] . "&custentity_mob_cc=" . str_replace("+","",$curldata['custentity_mob_cc']) . "&custentity_mgto_enq_num=" . $id . "&companyname=&firstname=" . $curldata['firstname'] . "&lastname=" . $curldata['lastname'] . "&phone=" . $curldata['phone'] . "&email=" . $curldata['email'] . "&custentity_lead_cruise_date=" . $curldata['custentity_lead_cruise_date'] . "&custentity_est_start_time=" . $curldata['custentity_est_start_time'] . "&custentity_duration_formattedValue=" . $curldata['custentity_duration'] . "&custentity_duration=" . $curldata['custentity_duration'] . "&custentity_duration_type=" . $curldata['custentity_duration_type'] . "&custentity_min_no_of_guests_formattedValue=" . $curldata['custentity_min_no_of_guests'] . "&custentity_min_no_of_guests=" . $curldata['custentity_min_no_of_guests'] . "&custentity_max_no_of_guests_formattedValue=" . $curldata['custentity_max_no_of_guests'] . "&custentity_max_no_of_guests=" . $curldata['custentity_max_no_of_guests'] . "&custentity_event_type=" . $curldata['custentity_event_type'] . "&custentity_source_url=https://www.anyboat.com.au&comments=" . $curldata['remark'] . "&custentity_how_did_you_hear_about_us=" . $curldata['custentity_how_did_you_hear_about_us'] . "&custentity_product_name_magento=" . trim($curldata['comments']) . "&custentity_number_person=" . $curldata['custentity_number_person'] . "&custentity2=" . $curldata['pricerange'] ."&submitter=Submit&_eml_nkey_=0&selectedtab=&nsapiPI=&nsapiSR=&nsapiVF=&nsapiFC=&nsapiPS=&nsapiVI=&nsapiVD=&nsapiPD=&nsapiVL=&nsapiRC=&nsapiLI=&nsapiLC=&nsapiCT=1580818098828&nsbrowserenv=istop=T&wfPI=&wfSR=&wfVF=&wfFC=&wfPS=&type=Customer&id=&externalid=&whence=https://4989106.extforms.netsuite.com/app/site/crm/externalleadpage.nl?compid=4989106&formid=5&h=AACffht_RwXaHO8V4_KPRyQt_ulBGaUv9IE&customwhence=&entryformquerystring=compid=4989106&formid=5&h=AACffht_RwXaHO8V4_KPRyQt_ulBGaUv9IE&redirect_count=1&did_javascript_redirect=T&wfinstances=&h=AACffht_RwXaHO8V4_KPRyQt_ulBGaUv9IE&compid=4989106&formid=5&subsidiary=3&forminstance=1d4e982f-5866-4fd7-bd3c-0e504c115db0&custentity_mgto_boat_rn=" . $curldata['custentity_mgto_boat_rn'] . "&submitted=&formdisplayview=NONE&_button=&";

        /* end of new anyboat code*/

        //set options
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
       
        //set data to be posted
        curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string."&isPerson=1");

        //perform our request
        $result = curl_exec($curl_connection);
        //print_r($result);
        //show information regarding the request
        echo "<pre>";
        
        $info =  curl_getinfo($curl_connection);

        if($info['url'] == 'https://www.anyboat.com.au/?subsidiary=3'){
            $boat = $this->boat->create()->load($id);
            $boat->setFinishtime($this->_date->gmtDate());
            $boat->setApistatus(1);
            $boat->save();
        }

        //print_r(curl_getinfo($curl_connection));
        echo "</pre>";

        //close the connection
        curl_close($curl_connection);
      }
  }
}
