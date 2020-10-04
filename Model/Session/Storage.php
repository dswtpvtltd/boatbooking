<?php
namespace Dreamsunrise\Boatbooking\Model\Session;

use Magento\Store\Model\StoreManagerInterface;

class Storage extends \Magento\Framework\Session\Storage
{
    public function __construct(
        StoreManagerInterface $storeManager,
        $namespace = 'boatbookingsession',
        array $data = []
    ) {
        parent::__construct($namespace, $data);
    }
}