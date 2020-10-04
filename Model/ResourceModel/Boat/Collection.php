<?php
namespace Dreamsunrise\Boatbooking\Model\ResourceModel\Boat;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Psr\log\LoggerInterface as Logger;

class Collection extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{
   public function __construct(
       EntityFactory $entityFactory,
       Logger $logger,
       FetchStrategy $fetchStrategy,
       EventManager $eventManager,
       $mainTable = 'boatbooking',
       $resourceModel = 'Dreamsunrise\Boatbooking\Model\ResourceModel\Boat'
   )
   {
      parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
   }
}