<?php
namespace Dreamsunrise\Boatbooking\Cron;

use Dreamsunrise\Boatbooking\Model\BoatFactory;
use Psr\Log\LoggerInterface;

class Boatenquiry{
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

  public function execute()
  {
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
        $curldata['telephone']            = $rows[0]['phone'];

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
                                'Other' => 22,
                                'Birthday Cruise' => 23,
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
            $data['traffic_source'] = "enquiry";

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
                $sql = "update " . $tableName . " set traffic_source = 'enquiry' where hit_id=" . $hitid;
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

        $curl_connection = curl_init('https://forms.na2.netsuite.com/app/site/crm/externalleadpage.nl');
        if(empty($curldata['comments'])){
            $curldata['comments'] = "From Anyboat Contact us page";
        }

        $post_string = "custentity2=" . $curldata['pricerange'] . "&companyname=&firstname=" . $curldata['firstname'] . "&lastname=" . $curldata['lastname'] . "&phone=" . $curldata['telephone'] . "&email=" . $curldata['email'] . "&custentity_lead_cruise_date=" . $curldata['custentity_lead_cruise_date'] . "&custentity_est_start_time=" . $curldata['custentity_est_start_time'] . "&custentity_duration_formattedValue=" . $curldata['custentity_est_start_time'] . "&custentity_duration=" . $curldata['custentity_duration']. "&custentity_mgto_boat_rn=" . $curldata['custentity_mgto_boat_rn'] . "&custentity_duration_type=" . $curldata['custentity_duration_type'] . "&custentity_min_no_of_guests_formattedValue=" . $curldata['custentity_min_no_of_guests'] . "&custentity_min_no_of_guests=" . $curldata['custentity_min_no_of_guests'] . "&custentity_max_no_of_guests_formattedValue=" . $curldata['custentity_max_no_of_guests'] . "&custentity_max_no_of_guests=" . $curldata['custentity_max_no_of_guests'] . "&custentity_event_type=" . $curldata['custentity_event_type'] . "&custentity_source_url=https://www.anyboat.com.au&comments=" . $curldata['remark'] . "&custentity_how_did_you_hear_about_us=" . $curldata['custentity_how_did_you_hear_about_us'] . "&custentity_product_name_magento=" . $curldata['comments'] . "&custentity_number_person=" . $curldata['custentity_number_person'] . "&submitter=Submit&_eml_nkey_=0&selectedtab=&nsapiPI=&nsapiSR=&nsapiVF=&nsapiFC=&nsapiPS=&nsapiVI=&nsapiVD=&nsapiPD=&nsapiVL=&nsapiRC=&nsapiLI=&nsapiLC=&nsapiCT=1521793547065&nsbrowserenv=istop=T&wfPI=&wfSR=&wfVF=&wfFC=&wfPS=&type=Customer&id=&externalid=&whence=https://system.na2.netsuite.com/app/site/crm/externalleadpage.nl?compid=4966220&formid=1&h=AACffht_T-1Mz9PGKCAAm4Z0-gYKznaouuo&customwhence=&entryformquerystring=compid=4966220&formid=1&h=AACffht_T-1Mz9PGKCAAm4Z0-gYKznaouuo&redirect_count=1&did_javascript_redirect=T&formid=1&h=AACffht_T-1Mz9PGKCAAm4Z0-gYKznaouuo&redirect_count=1&did_javascript_redirect=T&wfinstances=&h=AACffht_T-1Mz9PGKCAAm4Z0-gYKznaouuo&compid=4966220&formid=1&subsidiary=-1&forminstance=1d59da6e-d370-468c-898a-1d5c05c42741&submitted=&formdisplayview=NONE&_button=";

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

        //show information regarding the request
        echo "<pre>";

        $info =  curl_getinfo($curl_connection);

        print_r($info);

        if($info['url'] == 'https://www.anyboat.com.au/'){
            $boat = $this->boat->create()->load($id);
            $boat->setFinishtime($this->_date->gmtDate());
            $boat->setApistatus(1);
            $boat->save();
        }

        print_r(curl_getinfo($curl_connection));
        echo "</pre>";

        //close the connection
        curl_close($curl_connection);
      }
  }
}
