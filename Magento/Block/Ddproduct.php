<?php
/**
 * Ocodewire_Dailydeal Product widget
 *
 * @category    Catalog
 * @package     Ocodewire_Dailydeal
 * @author      Ocodewire <magento@browsewire.net>
 */

class Ocodewire_Dailydeal_Block_Ddproduct
    extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{

	protected function _construct() {
		parent::_construct();
	}
	
   /**
     * Produces Daily Deal Product html
     *
     * @return string
     */
    protected function _toHtml() {
		
		$html = '';        
        $this->assign('ddproduct');
        return parent::_toHtml();
    }

}
