 <?php

class Adestra_MFSubscriptions_Block_Adminhtml_Renderer_Type extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
         $value = $row->getData($this->getColumn()->getIndex());
		 if ($value == 1) return 'Subscribe';
		 else if ($value == 0) return 'Unsubscribe all';
    }
}

?> 