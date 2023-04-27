<?php
use Magento\Framework\App\Bootstrap;
include('app/bootstrap.php');
$bootstrap = Bootstrap::create(BP, $_SERVER);

$objectManager = $bootstrap->getObjectManager();

$state = $objectManager->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');

$product = $objectManager->create('Magento\Catalog\Model\Product');
$product->setName('Producto Uno');
$product->setTypeId('simple');
$product->setAttributeSetId(4);
$product->setSku('1000');
$product->setWebsiteIds(array(1));
$product->setVisibility(4);
$product->setPrice(0);
$product->setStatus(1);
$product->setStockData(array(
        'use_config_manage_stock' => 0,
        'manage_stock' => 0,
        'min_sale_qty' => 1, 
        'is_in_stock' => 1
        )
    );
$product->save();

$product2 = $objectManager->create('Magento\Catalog\Model\Product');
$product2->setName('Producto Dos');
$product2->setTypeId('simple');
$product2->setAttributeSetId(4);
$product2->setSku('1001');
$product2->setWebsiteIds(array(1));
$product2->setVisibility(4);
$product2->setPrice(0);
$product2->setStatus(1);
$product2->setStockData(array(
        'use_config_manage_stock' => 0,
        'manage_stock' => 0,
        'min_sale_qty' => 1, 
        'is_in_stock' => 1
        )
    );
$product2->save();

$product3 = $objectManager->create('Magento\Catalog\Model\Product');
$product3->setName('Producto Tres');
$product3->setTypeId('simple');
$product3->setAttributeSetId(4);
$product3->setSku('1003');
$product3->setWebsiteIds(array(1));
$product3->setVisibility(4);
$product3->setPrice(0);
$product3->setStatus(1);
$product3->setStockData(array(
        'use_config_manage_stock' => 0,
        'manage_stock' => 0,
        'min_sale_qty' => 1, 
        'is_in_stock' => 1
        )
    );
$product3->save();

$product4 = $objectManager->create('Magento\Catalog\Model\Product');
$product4->setName('Producto Cuatro');
$product4->setTypeId('simple');
$product4->setAttributeSetId(4);
$product4->setSku('1004');
$product4->setWebsiteIds(array(1));
$product4->setVisibility(4);
$product4->setPrice(0);
$product4->setStatus(1);
$product4->setStockData(array(
        'use_config_manage_stock' => 0,
        'manage_stock' => 0,
        'min_sale_qty' => 1, 
        'is_in_stock' => 1
        )
    );
$product4->save();


?>