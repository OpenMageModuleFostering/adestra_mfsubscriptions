<?php
class Adestra_MFSubscriptions_Adminhtml_MessagefocuslistsController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {  
        // Let's call our initAction method which will set some basic params for each action
        $this->_initAction()
            ->renderLayout();
    }  
     
    public function newAction()
    {  
        // We just forward the new action to a blank edit form
        $this->_forward('edit');
    }  
     
    public function editAction()
    {  
        $this->_initAction();
     
        // Get id if available
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('mfsubscriptions/list');
     
        if ($id) {
            // Load record
            $model->load($id);
     
            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This list no longer exists.'));
                $this->_redirect('*/*/');
     
                return;
            }  
        }  
     
        $this->_title($model->getId() ? $model->getDescription() : $this->__('New List'));
     
        $data = Mage::getSingleton('adminhtml/session')->getMessagefocuslistData(true);
        if (!empty($data)) {
            $model->setData($data);
        }  
     
        Mage::register('mfsubscriptions', $model);
     
        $this->_initAction()
            ->_addBreadcrumb($id ? $this->__('Edit List') : $this->__('New List'), $id ? $this->__('Edit List') : $this->__('New List'))
            ->_addContent($this->getLayout()->createBlock('mfsubscriptions/adminhtml_lists_edit')->setData('action', $this->getUrl('*/*/save')))
            ->renderLayout();
    }
	
	public function saveAction()
    {
        if ($postData = $this->getRequest()->getPost()) {
            $model = Mage::getSingleton('mfsubscriptions/list');
            $model->setData($postData);
 
            try {
				if ($model->status) {

					$collection = Mage::getResourceModel('mfsubscriptions/lists_collection')
					->addFieldToFilter('status',1)
					->addFieldToFilter('list_id',$model->getListId())
					->addFieldToFilter('scope_id',$model->getScopeId())
					->addFieldToFilter('id',array("neq"=>$model->getId()));
					if ($collection->count() > 0) {
							Mage::getSingleton('adminhtml/session')->addError($this->__('List ID '.$model->getListId().' already exists for the same website. Please try again or set to inactive.'));
							$this->_redirect('*/*/'); 
							return;					
					}

					if ($model->type == 1) $list = Mage::helper('mfsubscriptions')->adestra_fetch_list($model->getListId());
					else if ($model->type == 0) $list = Mage::helper('mfsubscriptions')->adestra_fetch_ubsublist($model->getUnsubListId());
					if (isset($list['name'])) {
						Mage::getSingleton('adminhtml/session')->addNotice('Successfully configured MessageFocus list: '.$list['name']);
					}
					else {
		                Mage::getSingleton('adminhtml/session')->addError($this->__('Could not connect to MessageFocus list ID: '.$model->getListId().'. Please try again or set to inactive.'));
						$this->_redirect('*/*/'); 
						return;
					}
										
				}
								
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The list has been saved.'));
				$this->_redirect('*/*/'); 
                return;
            }  
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this list.'));
            } 
            $this->_redirectReferer();
			return;
        }
    }
	
    public function deleteAction()
    {  
        $this->_initAction();
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('mfsubscriptions/list');
                $model->setId($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('mfsubscriptions')->__('The list has been deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to find the list to delete.'));
        $this->_redirect('*/*/');
	}
     
    public function messageAction()
    {
        $data = Mage::getModel('mfsubscriptions/list')->load($this->getRequest()->getParam('id'));
        echo $data->getContent();
    }
	
	
	    protected function _initAction()
    {
		$this->loadLayout()
			->_setActiveMenu('adestra/messagefocuslists')
			->_addBreadcrumb(Mage::helper('adminhtml')->__("MessageFocus List Manager"), Mage::helper('adminhtml')->__("MessageFocus List Manager"));
		$this->getLayout()->getBlock('head')->setTitle($this->__('Manage MessageFocus List / Adestra / Magento Admin'));
		return $this;         
    }
	
}    