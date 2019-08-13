<?php

class Adestra_MFSubscriptions_Model_Mysql4_List extends Mage_Core_Model_Mysql4_Abstract {
    protected function _construct()
    {
        $this->_init('mfsubscriptions/list', 'id');		
    }
} 

?>