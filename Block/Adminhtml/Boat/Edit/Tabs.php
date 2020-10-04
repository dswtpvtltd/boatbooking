<?php

namespace Dreamsunrise\Boatbooking\Block\Adminhtml\Boat\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('boatbooking_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Boat Booking'));
    }
}
