<?php

$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()->newTable($installer->getTable('mfsubscriptions/list'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'auto_increment' => true,
		'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true,
        ), 'ID')
    ->addColumn('list_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        ), 'List ID')
    ->addColumn('scope_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        ), 'Website Scope ID')
    ->addColumn('unsub_list_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        ), 'Unsub list ID')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
        ), 'List decription')
    ->addColumn('field', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => true,
        ), 'Data table field')
    ->addColumn('default_sub', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array(
		   'nullable' => false,
		   'default' => 0,
        ), 'Subscribed as default')
    ->addColumn('automatic_sub', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array(
		   'nullable' => false,
		   'default' => 0,
        ), 'Automatic subscription')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_BOOLEAN, 1, array(
		   'nullable' => false,
		   'default' => 0,
        ), 'Status active/inactive')
    ->addColumn('type', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		   'nullable' => false,
		   'default' => 1,
        ), 'List type: 1 = list, 0 = Unsubscribe all')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        ), 'List position (ascending)');
    //->setComment('Adestra MessageFocus Subscription list table');	
$installer->getConnection()->createTable($table);
$installer->endSetup(); 


?>