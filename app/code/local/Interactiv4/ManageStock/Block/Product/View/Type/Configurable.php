<?php
class Interactiv4_ManageStock_Block_Product_View_Type_Configurable extends Mage_Catalog_Block_Product_View_Type_Configurable
{
	
	public function getAllowProducts() {
        $allProducts = $this->getProduct()->getTypeInstance()->getUsedProducts();
        $this->setAllowProducts($allProducts);
        return $this->getData('allow_products');
    } 
	public function getJsonConfig()
    {
        $attributes = array();
        $options = array();
        $store = Mage::app()->getStore();
        foreach ($this->getAllowProducts() as $product) {
            $productId  = $product->getId();
        //var_dump(    'testo' . floor($product->getStockItem()->getQty())  ); 
            
            

            foreach ($this->getAllowAttributes() as $attribute) {
                $productAttribute = $attribute->getProductAttribute();
                $attributeValue = $product->getData($productAttribute->getAttributeCode());
                
                $options['qty'][$product -> getAttributeText($productAttribute->getName())] = floor($product->getStockItem()->getQty());
                
                
                if (!isset($options[$productAttribute->getId()])) {
                    $options[$productAttribute->getId()] = array();
                }

                if (!isset($options[$productAttribute->getId()][$attributeValue])) {
                    $options[$productAttribute->getId()][$attributeValue] = array();
                }
                $options[$productAttribute->getId()][$attributeValue][] = $productId;
            }
        }

        $this->_resPrices = array(
            $this->_preparePrice($this->getProduct()->getFinalPrice())
        );

        foreach ($this->getAllowAttributes() as $attribute) {
            $productAttribute = $attribute->getProductAttribute();
            $attributeId = $productAttribute->getId();
            $info = array(
               'id'        => $productAttribute->getId(),
               'code'      => $productAttribute->getAttributeCode(),
               'label'     => $attribute->getLabel(),
               'options'   => array()
            );

            $optionPrices = array();
            $prices = $attribute->getPrices();
            if (is_array($prices)) {
                foreach ($prices as $value) {
                    if(!$this->_validateAttributeValue($attributeId, $value, $options)) {
                        continue;
                    }

                    $info['options'][] = array(
                        'id'    => $value['value_index'],
                        'label' => ($options['qty'][$value['label']] <= 0) ? $value['label'] . ' * out of stock' : $value['label'] . " * (".$options['qty'][$value['label']]." in stock)",
                        'price' => $this->_preparePrice($value['pricing_value'], $value['is_percent']),
                        'products'   => isset($options[$attributeId][$value['value_index']]) ? $options[$attributeId][$value['value_index']] : array(),
                    	'class'=>($options['qty'][$value['label']] <= 0) ? 'disable' : 'enable',
                    );
                    $optionPrices[] = $this->_preparePrice($value['pricing_value'], $value['is_percent']);
                    //$this->_registerAdditionalJsPrice($value['pricing_value'], $value['is_percent']);
                }
            }
            /**
             * Prepare formated values for options choose
             */
            foreach ($optionPrices as $optionPrice) {
                foreach ($optionPrices as $additional) {
                    $this->_preparePrice(abs($additional-$optionPrice));
                }
            }
            if($this->_validateAttributeInfo($info)) {
               $attributes[$attributeId] = $info;
            }
        }
        /*echo '<pre>';
        print_r($this->_prices);
        echo '</pre>';die();*/

        $_request = Mage::getSingleton('tax/calculation')->getRateRequest(false, false, false);
        $_request->setProductClassId($this->getProduct()->getTaxClassId());
        $defaultTax = Mage::getSingleton('tax/calculation')->getRate($_request);

        $_request = Mage::getSingleton('tax/calculation')->getRateRequest();
        $_request->setProductClassId($this->getProduct()->getTaxClassId());
        $currentTax = Mage::getSingleton('tax/calculation')->getRate($_request);

        $taxConfig = array(
            'includeTax'        => Mage::helper('tax')->priceIncludesTax(),
            'showIncludeTax'    => Mage::helper('tax')->displayPriceIncludingTax(),
            'showBothPrices'    => Mage::helper('tax')->displayBothPrices(),
            'defaultTax'        => $defaultTax,
            'currentTax'        => $currentTax,
            'inclTaxTitle'      => Mage::helper('catalog')->__('Incl. Tax'),
        );

        $config = array(
            'attributes'        => $attributes,
            'template'          => str_replace('%s', '#{price}', $store->getCurrentCurrency()->getOutputFormat()),
//            'prices'          => $this->_prices,
            'basePrice'         => $this->_registerJsPrice($this->_convertPrice($this->getProduct()->getFinalPrice())),
            'oldPrice'          => $this->_registerJsPrice($this->_convertPrice($this->getProduct()->getPrice())),
            'productId'         => $this->getProduct()->getId(),
            'chooseText'        => Mage::helper('catalog')->__('Choose option...'),
            'taxConfig'         => $taxConfig,
        );

        return Zend_Json::encode($config);
    } 
}