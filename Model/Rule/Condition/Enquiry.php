<?php
namespace Dreamsunrise\Boatbooking\Model\Rule\Condition;

class Enquiry extends \Magento\Rule\Model\Condition\AbstractCondition
{
    public function __construct(
        \Magento\Rule\Model\Condition\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function loadAttributeOptions()
    {
        $this->setAttributeOption([
            'enquiry' => __('Condition for Boatbooking')
        ]);
        return $this;
    }

    public function getInputType()
    {
       return 'select';
    }

    public function getValueElementType()
    {
        return 'text';
    }

    public function validate(\Magento\Framework\Model\AbstractModel $model)
    {
        return parent::validate($model);
    }
}
