<?php 

class Adestra_MFSubscriptions_Block_Adminhtml_Customer_Edit_Tab_Subscriptions_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Initialize block
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Initialize form
     *
     * @return Mage_Adminhtml_Block_Customer_Edit_Tab_Subscriptions_Form
     */
    public function initForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('_subscriptions');
        $form->setFieldNameSuffix('subscriptions');

        $customer = Mage::registry('current_customer');

        /** @var $customerForm Mage_Customer_Model_Form */
//        $customerForm = Mage::getModel('customer/form');
//        $customerForm->setEntity($customer)
//            ->setFormCode('adminhtml_customer')
//            ->initDefaultValues();

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('mfsubscriptions')->__('Email Subscriptions')
        ));



        //$form->setValues($customer->getData());
        $this->setForm($form);
        return $this;
    }

}
