<?php

class Adestra_MFSubscriptions_Model_Resource_List extends Mage_Core_Model_Resource_Db_Abstract {
    protected function _construct()
    {
        $this->_init('mfsubscriptions/list', 'id');		
    }
} 

?>