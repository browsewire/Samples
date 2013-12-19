<?php
/**
 * Ocodewire_Dailydeal Product widget
 *
 * @category    Catalog
 * @package     Ocodewire_Dailydeal
 * @author      Ocodewire <magento@browsewire.net>
 */

    class Ocodewire_Dailydeal_Model_Price_Observer    {
        public function __construct()
        {
        }
        /**
         * set the special price , to anf from dates 
         * @param   Varien_Event_Observer $observer
         * @return  Xyz_Catalog_Model_Price_Observer
         */
        public function setCustomPrice($observer)
        {
			$event = $observer->getEvent();
			$product = $event->getProduct();


			$DailyDealPrice = $product->getDailyDealPrice();
			$DailyDealPriceFromDate = $product->getPriceFromDate();
			$DailyDealPriceToDate = $product->getPriceToDate();

			//echo $DailyDealPrice."<br />".$DailyDealPriceFromDate."<br />".$DailyDealPriceToDate;

			/** Set special price & to , from dates **/
			if( !empty( $DailyDealPrice ) ) 
				$product->setSpecialPrice( $DailyDealPrice   );
				
			if( !empty( $DailyDealPriceFromDate ) )  {
				$product->setSpecialFromDate($DailyDealPriceFromDate);
				//$product->setSpecialFromDateIsFormated(true);
			}

			if( !empty( $DailyDealPriceToDate ) )  {
				$product->setSpecialToDate($DailyDealPriceToDate);
				//$product->setSpecialToDateIsFormated(true);
			}

			//echo "<pre>";print_r( $product );echo "</pre>";exit;          
			return $this;
        }
    }
