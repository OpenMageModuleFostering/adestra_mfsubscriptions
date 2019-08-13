<?php

class Adestra_MFSubscriptions_Block_Adminhtml_Lists_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        
        // Set some defaults for our grid
        $this->setDefaultSort('id');
        $this->setId('mfsubscriptions_lists_grid');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }
     
    protected function _getCollectionClass()
    {
        // This is the model we are using for the grid
        return 'mfsubscriptions/lists_collection';
    }
     
    protected function _prepareCollection()
    {
        // Get and set our collection for the grid
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }
     
    protected function _prepareColumns()
    {
        // Add the columns that should appear in the grid		
		//$websites = Mage::app()->getWebsites();
		foreach (Mage::app()->getWebsites() as $website) {
			$options[$website->getId()] = $website->getName();
		}
        $this->addColumn('website',
            array(
                'header'=> $this->__('Website'),
                'index' => 'scope_id',
				'type' => 'options',
				'renderer' => new Adestra_MFSubscriptions_Block_Adminhtml_Renderer_Website(),
				'options' => $options
            )
        );
        $this->addColumn('type',
            array(
                'header'=> $this->__('List type'),
                'index' => 'type',
				'renderer' => new Adestra_MFSubscriptions_Block_Adminhtml_Renderer_Type(),
				'type' => 'options',
				'options' => array(1 => 'Subscribe', 0 => 'Unsubscribe All')
            )
        );
        $this->addColumn('description',
            array(
                'header'=> $this->__('List description'),
                'index' => 'description'
            )
        );
        $this->addColumn('list_id',
            array(
                'header'=> $this->__('List ID'),
                'index' => 'list_id',
				'renderer' => new Adestra_MFSubscriptions_Block_Adminhtml_Renderer_Number()
            )
        );
        $this->addColumn('unsub_list_id',
            array(
                'header'=> $this->__('Unsub list ID'),
                'index' => 'unsub_list_id',
				'renderer' => new Adestra_MFSubscriptions_Block_Adminhtml_Renderer_Number()
            )
        );
        $this->addColumn('field',
            array(
                'header'=> $this->__('Field'),
                'index' => 'field'
            )
        );
        $this->addColumn('default_sub',
            array(
                'header'=> $this->__('Subscribed as default'),
                'index' => 'default_sub',
				'renderer' => new Adestra_MFSubscriptions_Block_Adminhtml_Renderer_Checkbox()
            )
        );
        $this->addColumn('automatic_sub',
            array(
                'header'=> $this->__('Automatic subscription'),
                'index' => 'automatic_sub',
				'renderer' => new Adestra_MFSubscriptions_Block_Adminhtml_Renderer_Checkbox()
            )
        );
        $this->addColumn('status',
            array(
                'header'=> $this->__('Status'),
                'index' => 'status',
				'renderer' => new Adestra_MFSubscriptions_Block_Adminhtml_Renderer_Status(),
				'type' => 'options',
				'options' => array(1 => 'Active', 0 => 'Inactive')
            )
        );
        $this->addColumn('position',
            array(
                'header'=> $this->__('Position'),
                'index' => 'position',
				'width'    => 15,
            )
        );
		$this->addColumn('action_edit', array(
			'header'   => $this->__('Action'),
			'width'    => 15,
			'sortable' => false,
			'filter'   => false,
			'type'     => 'action',
			'getter'    => 'getId',
			'actions'  => array(
				array(
					'url'     => array('base'=> '*/*/edit'),
					'caption' => $this->__('Edit'),
					'field'     => 'id'
				),
			)
		));       
        return parent::_prepareColumns();
    }
     
    public function getRowUrl($row)
    {
        // This is where our row data will link to
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}