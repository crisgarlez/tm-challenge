<?php
namespace Crisgarlez\TiendaChallenge\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\InputException;

class CheckoutCartProductAddAfterObserver implements ObserverInterface {

    protected $messageManager;
    protected $zendClient;
    protected $_logger;
	
    public function __construct(\Magento\Framework\Message\ManagerInterface $messageManager, \Zend\Http\Client $zendClient) {
        $this->messageManager = $messageManager;
        $this->zendClient = $zendClient;
    }

    public function execute(\Magento\Framework\Event\Observer $observer) {
    
		$item = $observer->getEvent()->getData('quote_item');
        $product = $observer->getEvent()->getData('product');
		$item = ($item->getParentItem() ? $item->getParentItem() : $item);
		
        $url = 'http://service:3000/getAllSkuOffers/' . $product->getSku();

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
                
                $bestOffer = array_reduce($availableOffers, array($this, 'getBestOffer'));
                $bestPrice = $bestOffer->shipping_price + $bestOffer->price;
                
                if ($bestPrice !== $product->getPrice()) {
                    throw new InputException(__('El precio que usted seleccionó ya no se encuentra disponible, por favor recargue la página'));
                } elseif ($item->getQty() > $bestOffer->stock) {
                    throw new InputException(__('Sin stock!'));
                }
            }
            
            $item->setCustomPrice($bestPrice);
            $item->setOriginalCustomPrice($bestPrice);
            $item->setOfferid($bestOffer->id);
            $item->getProduct()->setIsSuperMode(true);
        
        } catch (\Zend\Http\Exception\RuntimeException $runtimeException) {
            // ERROR
        }

	}

    private function getBestOffer($carry, $item) {
        return (!isset($carry) || ($carry->shipping_price + $carry->price) > ($item->shipping_price + $item->price)) ? $item : $carry;
    }

}