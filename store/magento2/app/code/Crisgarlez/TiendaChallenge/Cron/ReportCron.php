<?php
namespace Crisgarlez\TiendaChallenge\Cron;

use Psr\Log\LoggerInterface;
use \Magento\Framework\App\ObjectManager;
use \Magento\Framework\Api\SearchCriteriaBuilder;

class ReportCron {

    protected $logger;
    protected $orderItemRepository;
    protected $searchCriteriaBuilder;

    public function __construct(LoggerInterface $logger, \Magento\Sales\Api\OrderItemRepositoryInterface $orderItemRepository, SearchCriteriaBuilder $searchCriteriaBuilder) {
        $this->logger = $logger;
        $this->orderItemRepository = $orderItemRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }
    
    public function execute() {

        $date = date("Y-m-d");
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('created_at', $date.' 00:00:00', 'gt')->create();
        $itemCollection = $this->orderItemRepository->getList($searchCriteria)->getItems();
        $reportData = [];

        foreach($itemCollection as $item) {
            $sku = $item->getSku();
            $qtyOrdered = $item->getQtyOrdered();
            $reportData[$sku] = ($reportData[$sku] ?? 0) + $qtyOrdered;
        }
        
        $objectManager = ObjectManager::getInstance();
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('cronreport');
        foreach($reportData as $sku => $count) {
            $sql = "INSERT INTO " . $tableName . " (sku, count, date) Values ('".$sku."','".$count."','".$date."')";
        }
        $connection->query($sql);
    }
}