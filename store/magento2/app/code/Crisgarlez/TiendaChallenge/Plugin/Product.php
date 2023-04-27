<?php
 
namespace Crisgarlez\TiendaChallenge\Plugin;
 
class Product {

    private $zendClient;

    public function __construct(\Zend\Http\Client $zendClient) {
        $this->zendClient = $zendClient;
    }

    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
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
                $result = array_reduce($availableOffers, array($this, 'getBestCost'));
            }
        } catch (\Zend\Http\Exception\RuntimeException $runtimeException) {
            // ERROR
        }

        return $result;
        
    }

    private function getBestCost($carry, $item) {
        $totalCost = $item->shipping_price + $item->price;
        return (!isset($carry) || $carry > $totalCost) ? $totalCost : $carry;
    }
}