<?php
class Adestra_MFSubscriptions_Model_Resource_Lists_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {  
        $this->_init('mfsubscriptions/list');
    }  
}