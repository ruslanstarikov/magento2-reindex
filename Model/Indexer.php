<?php

namespace Triple888\Reindexer\Model;

use Magento\Indexer\Model\IndexerFactory;
use Magento\Indexer\Model\Indexer\CollectionFactory;
use Magento\Framework\Indexer\ConfigInterface;

class Indexer
{
    protected $indexFactory;
    protected $indexCollection;
    protected $config;

    public function __construct(
        IndexerFactory $indexFactory,
        CollectionFactory $indexCollection,
        ConfigInterface $config
    ){
        $this->indexFactory = $indexFactory;
        $this->indexCollection = $indexCollection;
        $this->config = $config;
    }

    public function reindex(string $indexId) : bool
    {
        try {
            $indexer = $this->indexFactory->create()->load($indexId);
            $indexer->reindexAll();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function reindexAll() : bool
    {
        foreach (array_keys($this->config->getIndexers()) as $indexerId) {
            try {
                $indexer = $this->indexFactory->create()->load($indexerId);
                $indexer->reindexAll();
            } catch (\Exception $e) {
                return false;
            }
        }

        return true;
    }
}