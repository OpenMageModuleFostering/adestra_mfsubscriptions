 <?php

class Adestra_MFSubscriptions_Block_Adminhtml_Renderer_Website extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
         $website_id = $row->getData($this->getColumn()->getIndex());
		 $read = Mage::getSingleton('core/resource')->getConnection('core_read');
		 $select = $read->select();
		 $select->from('core_website', 'name')
			   ->where('website_id = ?', $website_id);
		 $name = $read->fetchOne($select);  
         return $name;
    }
}

?> 