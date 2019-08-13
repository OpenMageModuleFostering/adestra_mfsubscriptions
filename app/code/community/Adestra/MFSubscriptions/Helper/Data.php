<?php
/*
* Adestra_MFSubscriptions_Helper
*/

class Adestra_MFSubscriptions_Helper_Data extends Mage_Core_Helper_Abstract{
	

	function adestra_xmlrpc_endpoint() {
		$config = array('accountid','apiendpoint','apiusername','apipassword','enabled');
		$config = Mage::helper('mfsubscriptions')->getConfigData($config);
		$endpoint = parse_url($config['apiendpoint']);
		$url = $endpoint['scheme'] . '://';
		$url .= $config['accountid'].'.';
		$url .= $config['apiusername'].':';
		$url .= $config['apipassword'].'@';
		$url .= $endpoint['host'].$endpoint['path'];
		return $url;
	}
	
	function adestra_call($method, $arguments = array()) {
		
		try {					
			$url = $this->adestra_xmlrpc_endpoint();
			$client = new Zend_XmlRpc_Client($url);
			$debug = Mage::getStoreConfig('adestra/mfsubscriptions/debug');
			if ($debug) {
				 Mage::Log('Adestra method: '.$method);
				 Mage::Log('Arguments: ');
				 Mage::Log($arguments);
			}
			$result = $client->call($method,$arguments);			
			if ($debug) {
				Mage::Log('Result: ');
				Mage::Log($result);
			}
						
		} catch(Exception $e) {
			
			Mage::Log($e->getMessage());
			Mage::Log($e->getCode());
			$result = FALSE;
			if(Mage::getSingleton('admin/session')->isLoggedIn()) {
				Mage::getSingleton('adminhtml/session')->addError('The XML-RPC server returned this response. Code: '.$e->getCode().'<br />Message: '.var_export($e->getMessage(),TRUE));
			}
		}
		
		return $result;
	}
		


	/* 
	** Adestra API calls
	** See: http://new.adestra.com/doc/page/current/index/api
	*/	
	function adestra_get_core_table($id=NULL) {
		if (!$id) {
			$id = $this->getConfigData(array('coretableid'));
		}
		$table = $this->adestra_call('coreTable.get',$id);
		return $table;
	}

	function adestra_get_workspace($id=NULL) {
		if (!$id) {
			$id = $this->getConfigData(array('coretableid'));
		}
		$workspace = $this->adestra_call('workspace.get',$id);
		return $workspace;
	}
	
	function adestra_fetch_contacts($table_id = NULL, $data_table_ids = array(), $paging_args = NULL) {
	  if ($table_id === NULL) {
		$table_id = variable_get_value('adestra_default_table_id');
	  }
	  $contacts = $this->adestra_call('contact.all', array($table_id, $data_table_ids, $paging_args));
	  return $contacts;
	}
	
	function adestra_fetch_contact($id, $data_table_ids = NULL) {
	  $contact = $this->adestra_call('contact.get', array($id, $data_table_ids));
	  return $contact;
	}
	
	function adestra_fetch_contact_lists($id) {
	  $list_ids = $this->adestra_call('contact.lists', array($id));
	  return $list_ids;
	}
	
	function adestra_search_contacts($table_id = NULL, $search_args, $data_table_ids = NULL, $paging_args = NULL) {
	  if ($table_id === NULL) {
		$table_id = variable_get_value('adestra_default_table_id');
	  }
	  $contacts = $this->adestra_call('contact.search', array($table_id, $search_args, $data_table_ids, $paging_args));
	  return $contacts;
	}
	
	function adestra_create_contact($table_id = NULL, $contact_data, $dedupe_field = NULL) {
	  if ($table_id === NULL) {
		$table_id = variable_get_value('adestra_default_table_id');
	  }
	  $contact_id = $this->adestra_call('contact.create', array((integer)$table_id, $contact_data, $dedupe_field));
	  return $contact_id;
	}
	
	function adestra_update_contact($contact_id, $contact_data) {
	  $contact_id = $this->adestra_call('contact.update', array($contact_id, $contact_data));
	  return $contact_id;
	}
	
	function adestra_subscribe_contact($contact_id, $list_id) {
	  $result = $this->adestra_call('contact.addList', array($contact_id, $list_id));
	  return $result;
	}
	
	function adestra_subscribe_contact_multiple($contact_id, $list_ids = array(), $unsub_list_ids = array()) {
	  if (!empty($list_ids) || !empty($unsub_list_ids)) {
		$result = $this->adestra_call('contact.subscribe', array($contact_id, array_values($list_ids), array_values($unsub_list_ids)));
		return $result;
	  }
	}
	
	function adestra_unsubscribe_contact($contact_id, $list_id) {
	  $result = $this->adestra_call('contact.removeList', array($contact_id, $list_id));
	  return $result;
	}
	function adestra_unsubscribe_contact_multiple($contact_id, $list_ids = array(), $unsub_list_ids = array()) {
	  if (!empty($list_ids) || !empty($unsub_list_ids)) {
		$result = $this->adestra_call('contact.unsubscribe', array($contact_id, array_values($list_ids), array_values($unsub_list_ids)));
		return $result;
	  }
	}
	
	function adestra_import_contacts($contact_id, $data_file_url, $options) {
	  $result = $this->adestra_call('contact.import', array($contact_id, $data_file_url, $options));
	  return $result;
	}
	
	function adestra_send_email($contact, $campaign_id, $transaction_data) {
	  $result = $this->adestra_call('contact.transactional', array($contact, $campaign_id, $transaction_data));
	  return $result;
	}
	
	function adestra_fetch_list($id) {
	  $list = $this->adestra_call('list.get', array($id));
	  return $list;
	}
	
	function adestra_fetch_lists($paging_args = NULL) {
	  $lists = $this->adestra_call('list.all', array($paging_args));
	  return $lists;
	}
	
	function adestra_search_lists($search_args, $paging_args = NULL) {
	  $lists = $this->adestra_call('list.search', array($search_args, $paging_args));
	  return $lists;
	}
	
	function adestra_create_list($create_args) {
	  $lists = $this->adestra_call('list.create', array($create_args));
	  return $lists;
	}
	
	function adestra_update_list($id, $update_args) {
	  $result = $this->adestra_call('list.update', array($id, $update_args));
	  return $result;
	}

	function adestra_fetch_ubsublist($id) {
	  $list = $this->adestra_call('unsubList.get', array($id));
	  return $list;
	}
	
	function adestra_unsublist_add_address($email,$unsub_list_id) {
	  $result = $this->adestra_call('unsubList.addAddress', array($email,$unsub_list_id));
	  return $result;
	}
	
	function adestra_unsublist_remove_address($email,$unsub_list_id) {
	  $result = $this->adestra_call('unsubList.removeAddress', array($email,$unsub_list_id));
	  return $result;
	}

	function adestra_unsublist_check($email,$unsub_list_id) {
	  $result = $this->adestra_call('unsubList.check', array($email,$unsub_list_id));
	  return $result;
	}

	function adestra_unsublist_check_all($email) {
	  $result = $this->adestra_call('unsubList.checkAll', array($email));
	  return $result;
	}

	/* 
	**********************************
	**********************************
	*/	

	
	// helper fuction to fetch config data value for correct website scope.
	function getConfigData($config,$website_id = NULL) {
		if (!$website_id) $website_id = Mage::app()->getWebsite()->getId();
		if($website_id == 0) {
			$code = Mage::App()->getRequest()->getParam('website');
			$websites = Mage::app()->getWebsites();
			foreach ($websites as $website) {
				if ($website->getCode() == $code) { $website_id = $website->getId(); }
			}
		}
		
		if (is_array($config)) {
			$config_array = array();
			foreach ($config as $key => $value) {
				$config_array[$value] = Mage::app()->getWebsite($website_id)->getConfig('adestra/mfsubscriptions/'.$value,$website_id);
				if ($value == 'accountid') $config_array['accountid'] = str_replace(' ','_',$config_array['accountid']);
			}
			return $config_array;
		}
		else return array();
		
	}
	
	// Helper function to get core table ID.
	function getCoreTableId($website_id) {
		if (!$website_id) $website_id = Mage::app()->getWebsite()->getId();
		return Mage::app()->getWebsite($website_id)->getConfig('adestra/mfsubscriptions/coretableid',$website_id);
	}
	
	// Helper function to retrieve customer contact
	// take first contact from list.
	// @param $customer - Magento customer object
	function getMFContactFromCustomer($customer) {
		$contact = NULL;
		if ($customer->getId()) {
			$core_table_id = $this->getCoreTableId($customer->getWebsiteId());
			$search_args = new stdClass();
			$search_args->email = $customer->getEmail();
			$result = $this->adestra_search_contacts($core_table_id, $search_args);
			if (count($result)) if ($result[0]['id']) $contact = array_shift($result);
		}
		return $contact;		
	}
	
	// Helper function to create/update MessageFocus contact
	function updateMFContact($customer_id) {
		if (!$customer_id) {
			return false;
		}		
		
		$customer = Mage::getModel('customer/customer')->load($customer_id); 
		$config = array('coretableid','coretablefieldsmapping');
		$config = $this->getConfigData($config,$customer->getWebsiteId());
		$core_table_id = $config['coretableid'];
		$core_table_fields = explode("\n",$config['coretablefieldsmapping']);

		$contact_data = new stdClass();
		$contact_data->email = $customer->email;
		$default_billing = NULL;
		$default_shipping = NULL;
		foreach($core_table_fields as $field) {
			$mapping = explode("|",$field);
			$mage_field = explode('.',$mapping[0]);
			$mf_field = $mapping[1];
			if ($mage_field[0] == 'account') {
				if ($mage_field[1] == 'gender') $customer_value = $customer->getAttribute('gender')->getSource()->getOptionText($customer->getGender());
				elseif ($mage_field[1] == 'dob') $customer_value = substr($customer->getDob(),0,10); 
				else $customer_value = $customer->{$mage_field[1]};
				
				if (!empty($customer_value)) {
					$contact_data->{$mf_field} = $customer_value;	
				}
			}
			if ($mage_field[0] == 'billing_address') {
				if (!$default_billing) $default_billing = Mage::getModel('customer/address')->load($customer->default_billing);
				
				if ($mage_field[1] == 'street1') $customer_value = $default_billing->getStreet1();
				elseif ($mage_field[1] == 'street2') $customer_value = $default_billing->getStreet2();
				else $customer_value = $default_billing->getData($mage_field[1]);	
					
				if (!empty($customer_value)) {
					$contact_data->{$mf_field} = $customer_value;	
				}	
			}
			if ($mage_field[0] == 'shipping_address') {
				if (!$default_shipping) $default_shipping = Mage::getModel('customer/address')->load($customer->default_shipping);

				if ($mage_field[1] == 'street1') $customer_value = $default_billing->getStreet1();
				elseif ($mage_field[1] == 'street2') $customer_value = $default_billing->getStreet2();
				else $customer_value = $default_billing->getData($mage_field[1]);	

				if (!empty($customer_value)) {
					$contact_data->{$mf_field} = $customer_value;	
				}				
			}
		}

		$contact = $this->getMFContactFromCustomer($customer);
		if (isset($contact['id'])) {
			$this->adestra_update_contact($contact['id'],$contact_data);
			return $contact['id']; 
		}
		else {
			return $this->adestra_create_contact($core_table_id,$contact_data);			
		}
		
	}
	
	public function getMFSubscribedLists($contact) {
		$subscribed_lists = array();
		if (isset($contact['id'])) {
			$subscribed_lists = $this->adestra_fetch_contact_lists($contact['id']);
		}
		return $subscribed_lists;
	}
	
	public function getActiveLists($customer = NULL, $subscription_only = FALSE) {
		if (!$customer) $website_id = Mage::app()->getStore()->getWebsiteId();
		else $website_id = $customer->getWebsiteId();
		
		$collection = Mage::getResourceModel('mfsubscriptions/lists_collection')
			  ->addFieldToFilter('scope_id',$website_id)
			  ->addFieldToFilter('status',1)
			  ->addOrder('position','asc');			  
		if ($subscription_only) $collection->addFieldToFilter('type',1);
		return $collection;
	}

	public function getAutomaticLists($customer = NULL) {
		if (!$customer) $website_id = Mage::app()->getStore()->getWebsiteId();
		else $website_id = $customer->getWebsiteId();
		
		$collection = Mage::getResourceModel('mfsubscriptions/lists_collection')
			  ->addFieldToFilter('scope_id',$website_id)
			  ->addFieldToFilter('status',1)
			  ->addFieldToFilter('type',1)
			  ->addFieldToFilter('automatic_sub',1)
			  ->addOrder('position','acs');
		return $collection;
	}

	public function getNonAutomaticLists($customer = NULL) {
		if (!$customer) $website_id = Mage::app()->getStore()->getWebsiteId();
		else $website_id = $customer->getWebsiteId();
		
		$collection = Mage::getResourceModel('mfsubscriptions/lists_collection')
			  ->addFieldToFilter('scope_id',$website_id)
			  ->addFieldToFilter('status',1)
			  ->addFieldToFilter('type',1)
			  ->addFieldToFilter('automatic_sub',0)
			  ->addOrder('position','asc');
		return $collection;
	}
	
	// Helper function to update contact field set to TRUE/FALSE
	public function updateMFContactFieldsBoolean($contact_id,$fields = array()) {
		if (!$contact_id) return FALSE;
		$contact_data = new stdClass();
		foreach($fields as $name => $value) {
			if ($value == TRUE) $contact_data->{$name} = TRUE;
			else $contact_data->{$name} = FALSE;			
		}
		
		return $this->adestra_update_contact($contact_id,$contact_data);
		
	}
	
	public function updateMFSubscriptions($contact_id, $customer, $subscribe_lists = array()) {
		
		if (!$contact_id) return FALSE;
		if (!$customer) return FALSE;
		
		$subscribed_to_lists = array();						
		$unsubscribe_from_lists = array();	
		$unsub_add_lists = array();
		$unsub_remove_lists = array();
		$unsub_all_remove_lists = array();
		$unsub_all_add_lists = array();
		$boolean_fields = array();
		$subscription_lists = $this->getActiveLists($customer);
		
		// Build array of list IDs to subscribe to.
		foreach($subscribe_lists as $key => $value) {	
			if ($value == 1) $subscribed_to_lists[] = $key;
		}

		// Build array of list IDs to subscribe from and
		// build array ubsub list IDs and
		// build array of fields with subscribe to
		// Remove unsub all list ids from subscribe to lists
		// Add to unsub all lists where found.
		foreach($subscription_lists as $list) {
					
			if($this->isSubscribeList($list->type)) { // Subscribe list type
				if (in_array($list->getListId(),$subscribed_to_lists) === TRUE) { // Subscribe to list.
					if ($list->getField()) $boolean_fields[$list->getField()] = 1;  // TRUE	
					if ($list->getUnsubListId()) $unsub_remove_lists[] = $list->getUnsubListId();
				}
				else {  // Unsubscribe from list
					$unsubscribe_from_lists[] = $list->getListId();
					if ($list->getUnsubListId()) $unsub_add_lists[] = $list->getUnsubListId();
					if ($list->getField()) $boolean_fields[$list->getField()] = 0;  // FALSE					
				}
			
			}
			elseif(!$this->isSubscribeList($list->type)) { // Unsubscribe all list
				
				if (in_array($list->getUnsubListId(),$subscribed_to_lists) === TRUE) { // Subscribe to list.
					unset($subscribed_to_lists[array_search($list->getUnsubListId(),$subscribed_to_lists,TRUE)]);
					$unsub_all_add_lists[] = $list->getUnsubListId();					
				}
				else {
					$unsub_all_remove_lists[] = $list->getUnsubListId();					
				}

				
			}
			
//Mage::Log($subscribed_to_lists);		
//			// Set up unsubscribe process.
//			if (in_array($tmp_list_id,$subscribed_to_lists) !== TRUE) {
//				if($this->isSubscribeList($list->type)) { // Subscribe list
//					$unsubscribe_from_lists[] = $list->getListId();
//					if ($list->getUnsubListId()) $unsub_add_lists[] = $list->getUnsubListId();
//					if ($list->getField()) $boolean_fields[$list->getField()] = 0;  // FALSE
//					//if ($list->getUnsubListId() > 0) $unsub_all_remove_lists[] = $list->getUnsubListId();
//				}
//				elseif(!$this->isSubscribeList($list->type)) {  // Unsubscribe all list 
//					$unsub_all_remove_lists[] = $list->getUnsubListId();
//				
//				}
//			}
//			// Set up subscribe process.
//			else {
//				if($this->isSubscribeList($list->type)) { // Subscribe list
//					if ($list->getField()) $boolean_fields[$list->getField()] = 1;  // TRUE	
//					if ($list->getUnsubListId()) $unsub_remove_lists[] = $list->getUnsubListId();
//				}
//				elseif(!$this->isSubscribeList($list->type)) {  // Unsubscribe all list 
//					unset($subscribed_to_lists[$list->getUnsubListId()]);
//					$unsub_all_add_lists[] = $list->getUnsubListId();					
//				}
//
//			}


		}
		
		// Subscribe user to lists
		if (!empty($subscribed_to_lists)) {
			$this->adestra_subscribe_contact_multiple($contact_id,$subscribed_to_lists, $unsub_remove_lists);
		}
		
		// Unsubscribe user from lists
		if (!empty($unsubscribe_from_lists)) {
			$this->adestra_unsubscribe_contact_multiple($contact_id,$unsubscribe_from_lists, $unsub_add_lists);
		}

		// update boolean contact fields
		if (!empty($boolean_fields)) {
			$this->updateMFContactFieldsBoolean($contact_id,$boolean_fields);
		}
		
		// Remove from Unsub All Lists
		foreach($unsub_all_remove_lists as $unsub_list_id) {
			$this->adestra_unsublist_remove_address($customer->email,$unsub_list_id);	
		}
		// Add to Unsub All Lists
		foreach($unsub_all_add_lists as $unsub_list_id) {
			$this->adestra_unsublist_add_address($customer->email,$unsub_list_id);	
		}
		
	}
	
	// Fetch list of user subscribed lists.
	// Note list in Magento must be active.
	public function getUserAccountSubscribedLists($contact,$customer = NULL) {
		
		if (!isset($contact['id'])) return array();
		
		if (!$customer) $website_id = Mage::app()->getStore()->getWebsiteId();
		else $website_id = $customer->getWebsiteId();

		$subscribed_lists = array();
		$mf_subscribed_lists = $this->adestra_fetch_contact_lists($contact['id']);
		$subscription_lists = Mage::getResourceModel('mfsubscriptions/lists_collection')
			  ->addFieldToFilter('scope_id',$website_id)
			  ->addFieldToFilter('status',1)
			  ->addFieldToFilter('automatic_sub',0)
			  ->addOrder('position','desc');
		
		foreach($subscription_lists as $list) {
			if (array_search($list->list_id,$mf_subscribed_lists)!==FALSE) $subscribed_lists[] = $list->description;	
		}
				
		return $subscribed_lists;
		
		
		
	}
	
	public function isMFSubscriptionsEnabled() {
		return Mage::getStoreConfig('adestra/mfsubscriptions/enabled')?TRUE:FALSE;
	}
	
	// Is Subscribe or Unsubscribe All list.
	public function isSubscribeList($type) {
		if ($type == 1) return TRUE;
		else return FALSE;
	}
		

		
} 