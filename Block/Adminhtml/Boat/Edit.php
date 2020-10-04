<?php
namespace Dreamsunrise\Boatbooking\Block\Adminhtml\Boat;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Dreamsunrise\Boatbooking\Model\BoatFactory;

class Edit extends Container
{
    protected $_coreRegistry;
    
    /**
     * Result page factory
     *
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * News model factory
     *
     * @var \Dreamsunrise\Boatowner\Model\BoatFactory
     */
    protected $_boatbookingFactory;

    public function __construct(
         Context $context,
         Registry $coreRegistry,
         PageFactory $resultPageFactory,
         BoatFactory $boatbookingFactory,
         array $data = []
    ) {
       parent::__construct($context,$data);
       $this->_coreRegistry = $coreRegistry;
       $this->_resultPageFactory = $resultPageFactory;
       $this->_boatbookingFactory = $boatbookingFactory;
    }

    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_boat';
        $this->_blockGroup = 'Dreamsunrise_Boatbooking';

        parent::_construct();

        $this->buttonList->add(
            'save_and_continue_edit',
            [
                'class' => 'save',
                'label' => __('Save and Continue Edit'),
                'data_attribute' => [
                    'mage-init' => ['button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form']],
                ]
            ],
            10
        );
    }

    public function getHeaderText()
    {
        $apply = $this->_coreRegistry->registry('current_boatbooking');
        
        if ($apply->getId()) {
            return __("Edit Boat Enquiry '%1'", $this->escapeHtml($apply->getFirstName()));
        } else {
            return __('New Boat Enquiry');
        }
    }
}
