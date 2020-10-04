<?php
namespace Dreamsunrise\Boatbooking\Model;

use Magento\Framework\Model\AbstractModel;

class Boat extends AbstractModel
{
    public function _construct()
    {
        $this->_init(\Dreamsunrise\Boatbooking\Model\ResourceModel\Boat::class);
    }
}