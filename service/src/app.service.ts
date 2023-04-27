import { Injectable } from '@nestjs/common';

@Injectable()
export class AppService {
  offers: any = [
    {
      sku: '1000',
      offers: [
        {
          id: 1,
          price: 100.0,
          stock: 5,
          shipping_price: 5.0,
          delivery_date: '2023-05-27',
          can_be_refunded: true,
          status: 'new',
          guarantee: true,
          seller: {
            name: 'Seller 1',
            qualification: 0,
            reviews_quantity: 0,
          },
        },
        {
          id: 2,
          price: 1.0,
          stock: 1,
          shipping_price: 5.0,
          delivery_date: '2023-05-27',
          can_be_refunded: true,
          status: 'new',
          guarantee: true,
          seller: {
            name: 'Seller 2',
            qualification: 0,
            reviews_quantity: 0,
          },
        },
        {
          id: 3,
          price: 200.0,
          stock: 2,
          shipping_price: 2.0,
          delivery_date: '2023-05-27',
          can_be_refunded: true,
          status: 'new',
          guarantee: true,
          seller: {
            name: 'Seller 2',
            qualification: 0,
            reviews_quantity: 0,
          },
        },
      ],
    },
  ];

  getHello(): string {
    return 'Hello World!';
  }

  getOffersBySku(sku: string) {
    const filteredOffers = this.offers.filter((offer) => {
      return offer.sku === sku;
    });
    const [offers] = filteredOffers;
    return offers;
  }
}
