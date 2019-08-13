<?php

class Adestra_MFSubscriptions_Block_Adminhtml_Lists extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'mfsubscriptions';
        $this->_controller = 'adminhtml_lists';
        $this->_headerText = $this->__('MessageFocus Lists');       
        parent::__construct();
    }
}