<?php

namespace Rmlocke\Downloads\Model\Download;

use Rmlocke\Downloads\Api\DownloadRepositoryInterface;
use Rmlocke\Downloads\Api\Data\DownloadInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\DataObject;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;

class DataProvider extends ModifierPoolDataProvider
{

    protected $loadedData;
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;
    /**
     * @var PoolInterface|null
     */
    private $pool;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param DownloadRepositoryInterface $downloadRepository
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        DownloadRepositoryInterface $downloadRepository,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        ?PoolInterface $pool = null
    )
    {
        $this->dataPersistor = $dataPersistor;
        $this->collection = $downloadRepository->getCollection();
        $this->pool = $pool;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
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

        $this->loadedData = [];

        $items = $this->collection->getItems();

        /**
         * @var DownloadInterface|DataObject $item
         */
        foreach ($items as $item) {
            $this->loadedData[$item->getEntityId()] = $item->getData();
        }

        $data = $this->dataPersistor->get('downloads_download');
        if (!empty($data)) {
            /**
             * @var DownloadInterface|DataObject $download
             */
            $download = $this->collection->getNewEmptyItem();
            $download->setData($data);
            $this->loadedData[$download->getEntityId()] = $download->getData();
            $this->dataPersistor->clear('downloads_download');
        }

        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $this->loadedData = $modifier->modifyData($this->loadedData);
        }

        return $this->loadedData;
    }
}
