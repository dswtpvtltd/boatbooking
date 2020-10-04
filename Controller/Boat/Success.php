<?php
namespace Dreamsunrise\Boatbooking\Controller\Boat;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Dreamsunrise\Boatbooking\Model\Session;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Success extends Action
{
    protected $_formKeyValidator;
    protected $_boatSession;
    
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;
    
    public function __construct(
            \Magento\Framework\App\Action\Context $context,
            \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
            ProductRepositoryInterface $productRepository,
            Session $boatSession
            ) 
    {
        $this->_boatSession = $boatSession;
        $this->productRepository = $productRepository;
        $this->_formKeyValidator = $formKeyValidator;
        parent::__construct($context);
    }

    /**
     * Add product to shopping cart action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Boat Enquiry Success'));
        $session = $this->_boatSession->getBoatSession();
        if(empty($session['products']))
        {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }
        $this->_boatSession->unsBoatSession();
        return $resultPage;
    }
}
