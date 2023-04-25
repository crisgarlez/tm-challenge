<?php
 
namespace Crisgarlez\TiendaChallenge\Plugin;
 
class Product {

    private $zendClient;
    protected $_logger;

    public function __construct(\Zend\Http\Client $zendClient, \Psr\Log\LoggerInterface $logger) {
        $this->zendClient = $zendClient;
        $this->_logger = $logger;
    }

    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        $this->_logger->debug('!!!afterGetPrice!!!');
        $url = 'http://service:3000/getAllSkuOffers/' . $subject->getSku();

        try {
            $this->zendClient->reset();
            $this->zendClient->setUri($url);
            $this->zendClient->setMethod(\Zend\Http\Request::METHOD_GET); 
            $this->zendClient->setHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]);
            $this->zendClient->send();
            $response = $this->zendClient->getResponse();
            $data = json_decode($response->getContent());

            if(isset($data->offers)) {
                $availableOffers = array_filter($data->offers, function($offer){ 
                    return $offer->stock > 0;
                });
                $newPrice = array_reduce($availableOffers, array($this, 'getBestCost'));
                $result = $newPrice;
            }
        } catch (\Zend\Http\Exception\RuntimeException $runtimeException) {
            // ERROR
            $this->_logger->debug($runtimeException->getMessage());
        }

        return $result;
        
    }

    private function getBestCost($carry, $item) {
        if(!isset($carry)) {
            $carry = $item->shipping_price + $item->price;
        } else if ($carry > ($item->shipping_price + $item->price)){
            $carry = $item->shipping_price + $item->price;
        }
        return $carry;
    }
}