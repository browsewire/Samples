<?php
/**
 * Ocodewire_Dailydeal Product widget
 *
 * @category    Catalog
 * @package     Ocodewire_Dailydeal
 * @author      Ocodewire <magento@browsewire.net>
 */

class Ocodewire_Dailydeal_Helper_Data extends Mage_Core_Helper_Abstract {
	
	public function logUpdate(Varien_Event_Observer $observer)  {
		
		/** Check if product attribute already exists **/
		$code = "daily_deal_opt";
		$attribute = Mage::getModel('catalog/resource_eav_attribute')->loadByCode('catalog_product',$code);
		if(  NULL == $attribute->getId() ) {
			
			$model = Mage::getModel('eav/entity_setup','core_setup');
			$data= array (
				'group'             => 'Daily Deal Product Options',
				'label'             => 'Set Product for Daily Deal',
				'note'              => '',
				'type'              => 'int',    //backend_type
				'input'             => 'boolean', //frontend_input
				'frontend_class'    => '',
				'backend'           => '',
				'frontend'          => '',
				'is_global' 		=> '1',
				'required'          => false,
				'visible_on_front'  => true,
				//'apply_to'          => 'simple',
				'is_configurable'   => false,
				'used_in_product_listing'   => true,
				'sort_order'        => 5,
			);
			$model->addAttribute('catalog_product','daily_deal_opt',$data);
						
			$datafeatured = array(
				'group' => 'Daily Deal Product Options',
				'input' => 'boolean',
				'type' => 'int',
				'label' => 'Set Product as Daily Deal Featured Product',
				'visible' => 1,
				'required' => 0,
				'user_defined' => 1,
				'searchable' => 1,
				'filterable' => 0,
				'comparable' => 0,
				'visible_on_front' => true,
				'used_in_product_listing'   => true,
				'visible_in_advanced_search' => 0,
				'is_html_allowed_on_front' => 0,
				'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
				);
				
			$model->addAttribute('catalog_product','daily_deal_featured',$datafeatured);
			
			$data1 = array(
				'group' => 'Daily Deal Product Options',
				'input' => 'text',
				'type' => 'text',
				'label' => 'Set Price',
				'visible' => 1,
				'required' => 0,
				'user_defined' => 1,
				'searchable' => 1,
				'filterable' => 0,
				'comparable' => 0,
				'visible_on_front' => true,
				'used_in_product_listing'   => true,
				'visible_in_advanced_search' => 0,
				'is_html_allowed_on_front' => 0,
				'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
				);
			$model->addAttribute('catalog_product','daily_deal_price',$data1);
			
			$data2 = array(
				'group' => 'Daily Deal Product Options',
				'input' => 'date',
				'type' => 'datetime',
				'label' => 'Set Price From Date',
				'backend' => "eav/entity_attribute_backend_datetime",
				'visible' => 1,
				'required' => 0,
				'user_defined' => 1,
				'searchable' => 1,
				'filterable' => 0,
				'comparable' => 0,
				'visible_on_front' => true,
				'used_in_product_listing'   => true,
				'visible_in_advanced_search' => 0,
				'is_html_allowed_on_front' => 0,
				'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
				);
			$model->addAttribute('catalog_product','price_from_date',$data2);
			
			$data3 = array(
				'group' => 'Daily Deal Product Options',
				'input' => 'date',
				'type' => 'datetime',
				'label' => 'Set Price To Date',
				'backend' => "eav/entity_attribute_backend_datetime",
				'visible' => 1,
				'required' => 0,
				'user_defined' => 1,
				'searchable' => 1,
				'filterable' => 0,
				'comparable' => 0,
				'visible_on_front' => true,
				'used_in_product_listing'   => true,
				'visible_in_advanced_search' => 0,
				'is_html_allowed_on_front' => 0,
				'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
				);
			$model->addAttribute('catalog_product','price_to_date',$data3);
		}
		
    }
}
