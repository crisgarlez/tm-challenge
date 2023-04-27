# Tiendamia Challenge: Cristhian García Vélez

Este repositorio fue desarrollado en base a los requerimientos de Tiendamia y consta de:

- Ambiente configurado mediante docker-compose
- service: Servicio REST de ofertas
- store: Tienda creada con Magento 2
- mysql: Base de Datos MySQL usada por la tienda
- elasticsearch: Base de Datos Elastick Search usada por la tienda

Se puede acceder a los servicios de la siguiente forma

- service: http://localhost:3000/getAllSkuOffers/1000
- store: http://localhost
- mysql: localhost, port=3306, user=root, password=root, database=magento
- elasticsearch: localhost, port=9200

## Instalación

Para instalar, ejecute los siguientes comandos: `docker-compose up --build`

Al ejecutar el comando sucederá lo siguiente

1. Se insertarán 4 productos a la BD
2. Se creará un servicio REST con ofertas para el producto con SKU 1000
3. Se creará la tabla cronreport para generar los reportes de ventas
   4.- Se agrega el campo offerid a las tablas sales_order_item y quote_item

## USO

1. Abrir el frontend en el navegador `http://localhost/`
2. Buscar el producto 'Producto'
3. Realizar la compra
4. Un cron se ejecutará diariamente a las 00:00 `(0 0 * * *)`
