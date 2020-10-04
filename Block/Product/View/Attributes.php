<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Product description block
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
namespace Dreamsunrise\Boatbooking\Block\Product\View;

use Magento\Catalog\Model\Product;
use Magento\Framework\Phrase;
use Magento\Framework\Pricing\PriceCurrencyInterface;

/**
 * Attributes attributes block
 *
 * @api
 * @since 100.0.2
 */
class Attributes extends \Magento\Catalog\Block\Product\View\Attributes
{
    /**
     * $excludeAttr is optional array of attribute codes to exclude them from additional data array
     *
     * @param array $excludeAttr
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAdditionalData(array $excludeAttr = [])
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $data = [];
        $product = $this->getProduct();
        $attributes = $product->getAttributes();
        foreach ($attributes as $attribute) {
            if ($this->isVisibleOnFrontend($attribute, $excludeAttr)) {
                $value = $attribute->getFrontend()->getValue($product);

                $boolean = array(1 => "Yes",0 => "No");

                if($attribute->getFrontendInput() == 'multiselect'){
                  $value = $product->getResource()->getAttribute($attribute->getAttributeCode())->getFrontend()->getValue($product);
                }elseif($attribute->getFrontendInput() == 'boolean'){
                    if($product->getData($attribute->getAttributeCode()) != ''):
                      $value = $boolean[$product->getData($attribute->getAttributeCode())];
                    endif;
                }elseif ($value instanceof Phrase) {
                    $value = (string)$value;
                } elseif ($attribute->getFrontendInput() == 'price' && is_string($value) && in_array($attribute->getAttributeCode(), array('price','new_low_season_rate','high_season_rate_layered'))) {
                    $value = $this->priceCurrency->convertAndFormat($value);
                } elseif ($attribute->getFrontendInput() == 'price' && is_string($value) && in_array($attribute->getAttributeCode(),array('max_hire','boat_length_layered','boat_length_metres_layered','min_guests','new_max_guests','standing_capacity_layered','transfers_layered','casual_buffet_layered'))) {
                    $value = (int)($value);
                }

                if($value != ''):
                  $data[$attribute->getAttributeCode()] = [
                      'label' => $attribute->getStoreLabel(),
                      'value' => $value,
                      'code' => $attribute->getAttributeCode(),
                  ];
                endif;
            }
        }
        return $data;
    }
}
