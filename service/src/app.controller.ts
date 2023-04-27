import { Controller, Get, Param } from '@nestjs/common';
import { AppService } from './app.service';

@Controller()
export class AppController {
  constructor(private readonly appService: AppService) {}

  @Get()
  getHello(): string {
    return this.appService.getHello();
  }

  @Get('getAllSkuOffers/:sku')
  async find(@Param('sku') sku: string) {
    return await this.appService.getOffersBySku(sku);
  }
}
