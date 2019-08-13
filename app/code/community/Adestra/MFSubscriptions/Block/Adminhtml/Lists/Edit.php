<?php
class Adestra_MFSubscriptions_Block_Adminhtml_Lists_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init class
     */
    public function __construct()
    {  
        $this->_blockGroup = 'mfsubscriptions';
        $this->_controller = 'adminhtml_lists';
     
        parent::__construct();
     
        $this->_updateButton('save', 'label', $this->__('Save List'));
        $this->_updateButton('delete', 'label', $this->__('Delete List'));
    }  
     
    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {  
        if (Mage::registry('mfsubscriptions')->getListId()) {
            return $this->__('Edit List');
        }  
        else {
            return $this->__('New List');
        }  
    }  
}