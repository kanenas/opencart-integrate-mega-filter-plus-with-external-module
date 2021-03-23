<?php
/*
Place this file to /catalog/controller/module/ folder
Create a Cron Job (usually) runnning every hour 
Example: 00	*	*	*	* wget -O /dev/null 'https://www.example.com/index.php?route=module/updatemfpcachev2' >/dev/null 2>&1
*/

class ControllerModuleUpdatemfpcachev2 extends Controller {
	public function index() {
		//echo "Started: " . date("Y-m-d H:i:s") . "<br />";
		$results = $this->db->query( "SELECT `product_id` FROM `" . DB_PREFIX . "product` WHERE `status` = 1 AND `mfilter_values` = ''");
		//print_r($results);
		if ($results) {
			foreach ($results->rows as $result) {
				if( $this->config->get( 'mfilter_plus_version' ) ) {
					require_once DIR_SYSTEM . 'library/mfilter_plus.php';
					Mfilter_Plus::getInstance( $this )->updateProduct( $result['product_id'] );
					//echo "product_id = " . $result['product_id'] . "<br />";
				}
			}
			//echo "Finished: " . date("Y-m-d H:i:s");
		}
		exit;
	}
}
