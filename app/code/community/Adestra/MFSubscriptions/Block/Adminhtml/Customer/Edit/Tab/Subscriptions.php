<?php 

/**
 * Adminhtml customer action tab
 *
 */
class Adestra_MFSubscriptions_Block_Adminhtml_Customer_Edit_Tab_Subscriptions extends Mage_Adminhtml_Block_Widget_Form
{


  protected function _prepareForm()
  {    
     
      //$form = new Varien_Data_Form();
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
                                      'enctype' => 'multipart/form-data'
                                   )
      );
	  
	  $customer = Mage::registry('current_customer');

	  $form->setHtmlIdPrefix('_subscription_lists');
	  $form->setFieldNameSuffix('subscription_lists');
		
	  $contact = NULL;
	  $subscribed_lists = NULL;
      $fieldset = $form->addFieldset('subscriptions_form', array('legend'=>$this->__('Email Subscriptions')));

	  // only display form for existing customers as conflict with website scope.
	  if($customer->getId()) {
	  	$contact = Mage::helper('mfsubscriptions')->getMFContactFromCustomer($customer);
		$subscribed_lists = Mage::helper('mfsubscriptions')->getMFSubscribedLists($contact);		
			foreach (Mage::helper('mfsubscriptions')->getActiveLists($customer) as $list) {  
				if ($list->getStatus()) {      
					$config = array(
					  'label'     => $list->getDescription(),
					  'required'  => FALSE,
					  'name'      => $list->getListId(),
					  'onclick'   => 'mfSubscribe(this.checked); this.value = this.checked ? 1 : 0;',
					  'value'	  => '0',
					  'checked'	  => FALSE,
					  'class'     => 'mf-subscribe'
					);
					
					if ($list->getAutomaticSub()) $config['label'] = $list->getDescription() .' [Automatic] ';
					if ($list->getDefaultSub()) $config['label'] = $list->getDescription().' [Default] ';

					// Subscribe lists only
					if ($list->type == 1) {			
						if ($customer->getId()) {
							if (array_search($list->getListId(),$subscribed_lists) !== FALSE) {
								$config['checked'] = TRUE;
								$config['value'] = '1';	
							}
						}
						else {
							if ($list->getAutomaticSub() && !$config['checked']) {
								$config['checked'] = TRUE;
								$config['value'] = '1';
							}
			
							if ($list->getDefaultSub() && !$config['checked']) {
								$config['checked'] = TRUE;
								$config['value'] = '1';
							}					
						}	
						$fieldset->addField($list->getListId(), 'checkbox', $config);
					}
					
					// Unsubscribe all lists only.
					elseif ($list->type == 0) {
						$config['class']  = 'mf-unsubscribe';
						$config['onclick'] = 'mfUnsubscribeAll(this.checked); this.value = this.checked ? 1 : 0;';	
						$config['name']    = $list->getUnsubListId();
						if ($customer->getId()) {
							if(Mage::helper('mfsubscriptions')->adestra_unsublist_check($customer->email,$list->getUnsubListId())) {		
								$config['checked'] = TRUE;
								$config['value'] = '1';	
							}
						}
						$fieldset->addField($list->getUnsubListId(), 'checkbox', $config);
					}
								
				}
			}
	  }
	  else {		  	
			$config = array(
			  'label'     => 'Subscriptions are availble after the customer is added.',
			  'name'      => 'addcustomer',
			);
			$fieldset->addField('add', 'label', $config);
	  }
	  
          
          
      $this->setForm($form);
      return parent::_prepareForm();
  }

    public function getTabTitle()
    {
        return Mage::helper('mfsubscriptions')->__('Email Subscriptions');
    }

    public function canShowTab()
    {
        return true;
    }

    public function getTabUrl() 
    {
        return $this->getUrl('*/*/edit', array('_current' => true));
    }

    public function isHidden()
    {
        return false;
    }

}
?>