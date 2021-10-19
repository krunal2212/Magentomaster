<?php
namespace Magentomaster\Testmodule\Model\Contact;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magentomaster\Testmodule\Model\ResourceModel\Contact\CollectionFactory as ContactCollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * Loaded data cache
     *
     * @var array
     */
    protected $loadedData;

    /**
     * Data persistor
     *
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ContactCollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ContactCollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Magentomaster\Testmodule\Model\Contact $contact */
        foreach ($items as $contact) {
            $this->loadedData[$contact->getId()] = $contact->getData();

        }
        $data = $this->dataPersistor->get('magentomaster_testmodule_contact');
        if (!empty($data)) {
            $contact = $this->collection->getNewEmptyItem();
            $contact->setData($data);
            $this->loadedData[$contact->getId()] = $contact->getData();
            $this->dataPersistor->clear('magentomaster_testmodule_contact');
        }
        return $this->loadedData;
    }
}
