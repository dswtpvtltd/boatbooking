<?php
namespace Dreamsunrise\Boatbooking\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface  $context) 
    {
        $installer = $setup;
        
        $installer->startSetup();
        
        $tableowner = $installer->getConnection()
                ->newTable(
                 $installer->getTable("boatbooking")
                )
                ->addColumn(
                        "enquiry_id", 
                        Table::TYPE_INTEGER,
                        null,
                        ['identity' => true, "nullable" => false, "primary" => true],
                        "primary key of table(boatbooking enquiry table)"
                )
                ->addColumn(
                        "client_id",
                        Table::TYPE_INTEGER,
                        null,
                        ["nullable" => false],
                        "Id of affiliate cookies"
                )
                ->addColumn(
                        "itemid",
                        Table::TYPE_INTEGER,
                        null,
                        ["nullable" => false],
                        "id of product ids"
                )
                ->addColumn(
                        "traffic_id",
                        Table::TYPE_INTEGER,
                        null,
                        ["nullable" => false],
                        "cookies affilate trafic id"
                )
                ->addColumn(
                        "firstName",
                        Table::TYPE_TEXT,
                        255,
                        ['nullable' => false],
                        "First Name of customer"
                )
                ->addColumn(
                        "lastName", 
                        Table::TYPE_TEXT,
                        255,
                        ['nullable' => false],
                        "last name of customer"
                        )
                ->addColumn(
                        "apistatus",
                        Table::TYPE_INTEGER,
                        null,
                        ["nullable" => false],
                        "API run status 0 means not complete and 1 means cron completed"   
                )
                ->addColumn(
                        "companyName",
                        Table::TYPE_TEXT,
                        255,
                        ['nullable' => false],
                        "Company Name"
                )
                ->addColumn(
                        "comments",
                        Table::TYPE_TEXT,
                        255,
                        ['nullable' => false],
                        " customer comments"
                )
                ->addColumn(
                        "phone", 
                        Table::TYPE_TEXT,
                        255,
                        ['nullable' => false],
                        "phone number of Conatct Person"
                )
                ->addColumn(
                        "altPhone",
                         Table::TYPE_TEXT,
                         20,
                         ['nullable' => false],
                         "alternate Phone of Conatct person"    
                )
                ->addColumn(
                        "email",
                        Table::TYPE_TEXT,
                        255,
                        ['nullable' => false],
                        "Email id of Contact Person"    
                )
                ->addColumn(
                        "status",
                        Table::TYPE_INTEGER,
                        11,
                        ["nullable" => false, "default" => 0],
                        "status of record in table"
                )
                ->addColumn(
                     "image",
                      Table::TYPE_TEXT,
                      255,
                      ['nullable' => false],
                      "Address of Contact Person"   
                )
                ->addColumn(
                     "internalId",
                      Table::TYPE_INTEGER,
                      255,
                      ['nullable' => false],
                      "internalId from Netsuite"   
                )
                ->addColumn(
                     "isPerson",
                      Table::TYPE_INTEGER,
                      255,
                      ['nullable' => false],
                      "customer is person or company"   
                )
                ->addColumn(
                     "custentity_min_no_of_guests",
                      Table::TYPE_INTEGER,
                      255,
                      ['nullable' => false],
                      "number of minimum guests"   
                )
                ->addColumn(
                     "custentity_max_no_of_guests",
                      Table::TYPE_INTEGER,
                      255,
                      ['nullable' => false],
                      "number of maximum guest"   
                )
                ->addColumn(
                     "custentity_2663_direct_debit",
                      Table::TYPE_TEXT,
                      255,
                      ['nullable' => false],
                      "custentity_2663_direct_debit"   
                )
                ->addColumn(
                     "custentity_duration_type",
                      Table::TYPE_TEXT,
                      250,
                      ['nullable' => false],
                      "Duration Type"   
                )
                ->addColumn(
                     "custentity_duration",
                      Table::TYPE_TEXT,
                      250,
                      ['nullable' => false],
                      "Duration"   
                )
                ->addColumn(
                     "custentity_lead_cruise_date",
                      Table::TYPE_TEXT,
                      255,
                      ["nullable" => false],
                      "Lead Cruise Date"   
                )
                ->addColumn(
                     "custentity_number_person",
                      Table::TYPE_INTEGER,
                      11,
                      ["nullable" => false],
                      "number of person"   
                )
                ->addColumn(
                     "custentity_how_did_you_hear_about_us",
                      Table::TYPE_TEXT,
                      250,
                      ["nullable" => false],
                      "How Did You Hear About Us?"   
                )
                ->addColumn(
                     "custentity_event_type",
                      Table::TYPE_TEXT,
                      250,
                      ["nullable" => false],
                      "Event Type"   
                )
                ->addColumn(
                     "custentity_est_start_time",
                      Table::TYPE_TEXT,
                      250,
                      ["nullable" => false],
                      "Event Start Time"   
                )
                ->addColumn(
                     "custentity_product_name_magento",
                      Table::TYPE_TEXT,
                      1000,
                      ["nullable" => false],
                      "Event Start Time"   
                )
                ->addColumn(
                     "description",
                      Table::TYPE_TEXT,
                      1000,
                      ["nullable" => false],
                      "Description"   
                )
                ->addColumn(
                     "campaign_id",
                      Table::TYPE_INTEGER,
                      11,
                      ["nullable" => false],
                      "campaign_id"   
                )
                ->addColumn(
                     "score",
                      Table::TYPE_INTEGER,
                      5,
                      ["nullable" => false],
                      "score"   
                )
                ->addColumn(
                     "affiliate_id",
                      Table::TYPE_INTEGER,
                      5,
                      ["nullable" => false],
                      "affiliate_id"   
                )
                ->addColumn(
                     "pricerange",
                      Table::TYPE_TEXT,
                      500,
                      ["nullable" => false],
                      "Price Range"   
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Creation Time'
                )
                ->addColumn(
                    'runtime',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'cron completion Time'
                )
                ->addColumn(
                    'finishtime',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'cron finish Time'
                )
                ->addIndex(
                  $installer->getIdxName("boatbooking", ['firstName']),
                  ['firstName']
                )
                ->setComment("List of Boat Booking");
        
        $installer->getConnection()->createTable($tableowner);
        
        $installer->endSetup();
    }
}
