<?php
class Adestra_MFSubscriptions_Block_Adminhtml_Lists_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init class
     */
    public function __construct()
    {  
        parent::__construct();
     
        $this->setId('mfsubscriptions_lists_form');
        $this->setTitle($this->__('List Details'));
    }  
     
    /**
     * Setup form fields for inserts/updates
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {  
        $model = Mage::registry('mfsubscriptions');
		     
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post'
        ));
     
        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('mfsubscriptions')->__('List Details'),
            'class'     => 'fieldset-normal',
        ));
     
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
        }  
     
		$websites = Mage::app()->getWebsites();
		$options = array('0' => 'Please select');
		foreach ($websites as $website) {
			$options[$website->getId()] = $website->getName();
		}
        $fieldset->addField('scope_id', 'select', array(
            'name'      => 'scope_id',
            'label'     => Mage::helper('mfsubscriptions')->__('Website'),
            'title'     => Mage::helper('mfsubscriptions')->__('Website'),
            'required'  => true,
			'values' => $options,
			'class' => 'validate-website',
        ));
		
        $fieldset->addField('type', 'select', array(
            'name'      => 'type',
            'label'     => Mage::helper('mfsubscriptions')->__('List type'),
            'title'     => Mage::helper('mfsubscriptions')->__('List type'),
			'values' 	=> array(1 => 'Subscribe', 0 => 'Unsubscribe all'),
			'value'   => 1,
			'onchange'  => 'mfChangeListType(this.value)',
            'required'  => true,
        ));

        $fieldset->addField('description', 'text', array(
            'name'      => 'description',
            'label'     => Mage::helper('mfsubscriptions')->__('List description'),
            'title'     => Mage::helper('mfsubscriptions')->__('List description'),
            'required'  => true,
        ));
		
        $fieldset->addField('list_id', 'text', array(
            'name'      => 'list_id',
            'label'     => Mage::helper('mfsubscriptions')->__('List ID'),
            'title'     => Mage::helper('mfsubscriptions')->__('List ID'),
            //'required'  => true,
			'class' => 'validate-number',
        ));
    
        $fieldset->addField('unsub_list_id', 'text', array(
            'name'      => 'unsub_list_id',
            'label'     => Mage::helper('mfsubscriptions')->__('Unsub list ID'),
            'title'     => Mage::helper('mfsubscriptions')->__('Unsub list ID'),
            'required'  => false,
			'class' => 'validate-number',
        ));

        $fieldset->addField('field', 'text', array(
            'name'      => 'field',
            'label'     => Mage::helper('mfsubscriptions')->__('Field'),
            'title'     => Mage::helper('mfsubscriptions')->__('Field'),
            'required'  => false,
        ));

        $fieldset->addField('default_sub', 'select', array(
            'name'      => 'default_sub',
            'label'     => Mage::helper('mfsubscriptions')->__('Subscribed as default'),
            'title'     => Mage::helper('mfsubscriptions')->__('Subscribed as default'),
			'values' 	=> array(0 => 'No', 1 => 'Yes'),
            'required'  => false,
        ));
		
        $fieldset->addField('automatic_sub', 'select', array(
            'name'      => 'automatic_sub',
            'label'     => Mage::helper('mfsubscriptions')->__('Automatic subscription'),
            'title'     => Mage::helper('mfsubscriptions')->__('Automatic subscription'),
			'values' 	=> array(0 => 'No', 1 => 'Yes'),
            'required'  => false,
        ));

        $fieldset->addField('status', 'select', array(
            'name'      => 'status',
            'label'     => Mage::helper('mfsubscriptions')->__('Status'),
            'title'     => Mage::helper('mfsubscriptions')->__('Status'),
			'values' 	=> array(1 => 'Active', 0 => 'Inactive'),
            'required'  => false,
        ));
        $fieldset->addField('position', 'text', array(
            'name'      => 'position',
            'label'     => Mage::helper('mfsubscriptions')->__('Position'),
            'title'     => Mage::helper('mfsubscriptions')->__('Position'),
            'required'  => false,
			'class' => 'validate-number',
        ));

		$data = $model->getData();
		if (!isset($data['type'])) $data['type'] = 1;
		if (!isset($data['status'])) $data['status'] = 1;
        $form->setValues($data);
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }  
}