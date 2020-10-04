<?php

namespace Dreamsunrise\Boatbooking\Block\Adminhtml\Boat\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;

class Main extends Generic implements TabInterface
{
    protected $_wysiwygConfig;
    protected $_status;
    protected $_videoType;
    protected $_imageType;
    protected $_yesno;
    protected $_systemStore;
    protected $_category;
    protected $_eavAttribute;
    
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Eav\Api\AttributeRepositoryInterface $eavAttribute,
        array $data = []
    )
    {
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_eavAttribute = $eavAttribute;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    public function getTabLabel()
    {
        return __('General');
    }

    public function getTabTitle()
    {
        return __('General');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
    
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('current_boatbooking');
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('boatbooking_general_');
        $fieldset = $form->addFieldset('general_fieldset', ['legend' => __('General')]);
        
        if ($model->getEnquiryId()) {
            $fieldset->addField('enquiry_id', 'hidden', ['name' => 'boatbooking[enquiry_id]']);
        }
        
        $fieldset->addField(
            'firstName',
            'text',
            ['name' => 'boatbooking[firstName]', 'label' => __('First Name'), 'title' => __('First Name'), 'required' => true]
        );
        
        
        $fieldset->addField(
            'lastName',
            'text',
            ['name' => 'boatbooking[lastName]', 'label' => __('Last Name'), 'title' => __('Last Name'), 'required' => true,'default' => 0]
        );
        
        $fieldset->addField(
            'companyName',
            'text',
            ['name' => 'boatbooking[companyName]', 'label' => __('Company Name'), 'title' => __('Company Name'), 'required' => false]
        );
        
        $fieldset->addField(
            'phone',
            'text',
            ['name' => 'boatbooking[phone]', 'label' => __('Phone'), 'title' => __('Phone'), 'required' => false]
        );
        
        $fieldset->addField(
            'altPhone',
            'text',
            ['name' => 'boatbooking[altPhone]', 'label' => __('Alternative Phone'), 'title' => __('Alternative Phone'), 'required' => false]
        );
        
        $fieldset->addField(
            'email',
            'text',
            ['name' => 'boatbooking[email]', 'label' => __('Email'), 'title' => __('Alternative Phone'), 'required' => false]
        );
        
        $fieldset->addField(
            'custentity_min_no_of_guests',
            'text',
            ['name' => 'boatbooking[custentity_min_no_of_guests]', 'label' => __('Minimum No Of Guests'), 'title' => __('Minimum No Of Guests'), 'required' => false]
        );
        
        $fieldset->addField(
            'custentity_max_no_of_guests',
            'text',
            ['name' => 'boatbooking[custentity_max_no_of_guests]', 'label' => __('Maximum No Of Guests'), 'title' => __('Maximum No Of Guests'), 'required' => false]
        );
        
        $fieldset->addField(
            'custentity_duration_type',
            'text',
            ['name' => 'boatbooking[custentity_duration_type]', 'label' => __('Duration Type'), 'title' => __('Duration Type'), 'required' => false]
        );
        
        $fieldset->addField(
            'custentity_duration',
            'text',
            ['name' => 'boatbooking[custentity_duration]', 'label' => __('Duration'), 'title' => __('Duration'), 'required' => false]
        );
        
        $fieldset->addField(
            'custentity_lead_cruise_date',
            'text',
            ['name' => 'boatbooking[custentity_lead_cruise_date]', 'label' => __('Cruise Date'), 'title' => __('Cruise Date'), 'required' => false]
        );
        
        $fieldset->addField(
            'custentity_number_person',
            'text',
            ['name' => 'boatbooking[custentity_number_person]', 'label' => __('Number Person'), 'title' => __('Number Person'), 'required' => false]
        );
        
        $fieldset->addField(
            'custentity_event_type',
            'text',
            ['name' => 'boatbooking[custentity_event_type]', 'label' => __('Event Type'), 'title' => __('Event Type'), 'required' => false]
        );
        
        $fieldset->addField(
            'custentity_est_start_time',
            'text',
            ['name' => 'boatbooking[custentity_est_start_time]', 'label' => __('Start Time'), 'title' => __('Start Time'), 'required' => false]
        );
        
        $fieldset->addField(
            'description',
            'text',
            ['name' => 'boatbooking[description]', 'label' => __('Description'), 'title' => __('Description'), 'required' => false]
        );
        
        $fieldset->addField(
            'pricerange',
            'text',
            ['name' => 'boatbooking[pricerange]', 'label' => __('Price Range'), 'title' => __('Price Range'), 'required' => false]
        );
        
        $fieldset->addField(
            'comments',
            'editor',
            [
             'name'      => 'boatbooking[comments]', 
             'label'     => __('Comments'), 
             'title'     => __('Comments'),
             'config'    => $this->_wysiwygConfig->getConfig(),
             'required'  => false,
             'wysiwyg'   => true,
             'after_element_html' => ''
            ]
        );
        
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
