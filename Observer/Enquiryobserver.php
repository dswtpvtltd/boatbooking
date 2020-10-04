<?php
namespace Dreamsunrise\Boatbooking\Observer;

class Enquiryobserver implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param \Magento\Rule\Model\Condition\Context $context
     * @param \Aheadworks\Affiliate\Model\Campaign\Condition\Cart\Condition\Product $ruleConditionProduct
     * @param array $data
     */
    public function __construct(
        \Magento\Rule\Model\Condition\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->setType(\Dreamsunrise\Boatbooking\Model\Rule\Condition\Enquiry::class);
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $additional = $observer->getAdditional();
        $conditions = parent::getNewChildSelectOptions();
        return $conditions;
    }
}
