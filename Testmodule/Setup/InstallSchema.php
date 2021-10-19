<?php
namespace Magentomaster\Testmodule\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * install tables
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('magentomaster_testmodule_contact')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('magentomaster_testmodule_contact')
            )
            ->addColumn(
                'contact_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'Contact ID'
            )
            ->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                ['nullable => false'],
                'Contact Name'
            )
            ->addColumn(
                'email',
                Table::TYPE_TEXT,
                255,
                ['nullable => false'],
                'Contact Email'
            )
            ->addColumn(
                'phone',
                Table::TYPE_TEXT,
                255,
                [],
                'Contact Phone'
            )
            ->addColumn(
                'message',
                Table::TYPE_TEXT,
                '64k',
                ['nullable => false'],
                'Contact Message'
            )

            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT
                ],
                'Contact Created At'
            )
            ->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT_UPDATE
                ],
                'Contact Updated At'
            )
            ->setComment('Contact Table');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('magentomaster_testmodule_contact'),
                $setup->getIdxName(
                    $installer->getTable('magentomaster_testmodule_contact'),
                    ['name', 'email', 'phone', 'message'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['name', 'email', 'phone', 'message'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        $installer->endSetup();
    }
}
