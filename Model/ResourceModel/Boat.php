<?php
namespace Dreamsunrise\Boatbooking\Model\ResourceModel;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Boat extends AbstractDb
{
    protected function _construct() {
       $this->_init("boatbooking","enquiry_id");
    } 
}
