 <?php
 
class Adestra_MFSubscriptions_Block_Adminhtml_Customer_Edit_Tabs extends Mage_Adminhtml_Block_Customer_Edit_Tabs
{
    protected function _prepareLayout()
    {
		//$config = Mage::helper('mfsubscriptions')->getConfigData(array('enabled'));
		if (Mage::getStoreConfig('adestra/mfsubscriptions/enabled')) {
	
			$customer = Mage::registry('current_customer');
			if ($customer->getId()) {
				$this->addTab('chart', array(
						'label'     => Mage::helper('mfsubscriptions')->__('Email Subscriptions'),
						'content'   => $this->getLayout()->createBlock('mfsubscriptions/adminhtml_customer_edit_tab_subscriptions')->toHtml(),
					));
			}
			return parent::_prepareLayout();
		}
	}

 } 
 
 