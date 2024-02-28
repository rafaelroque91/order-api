## Order API
Laravel project using JSON:API patterns


### Project created using these technologies
- PHP 8.3
- Laravel Framework 10
- MySQL 8
- Nginx
- MySQL

### Containers
- order_api_php_fpm: PHP8.3 fpm Container
- order_api_nginx: Nginx Web Server Container
- order_api_mysql: MYSQL8 Container

## Preparing env.

### Requirements
- Windows with WSL2 / Ubuntu / MacOs
- Docker
- docker-compose
- git


## Setup the project
- clone the project
- copy the .env-exemple file to .env
- run this command
```
docker-compose up --build
```

if you want to seed the database, 
- run this command inside order_api_php_fpm container
```
php artisan db:seed
```

### Run tests
- run this command inside order_api_php_fpm container
```
php artisan test
```

## Endpoints

### Collection Postman
[Order api.postman_collection.json](Order%20api.postman_collection.json)


### Create Order

````
POST
curl --location 'http://localhost:61000/api/v1/orders' \
--header 'Accept: application/vnd.api+json' \
--header 'Content-Type: application/vnd.api+json' \
--data '{
    "data": {
        "type": "orders",
        "attributes": {
            "source": "amazon",
            "recipientName": "Rafael",
            "recipientPhone": "+18123456789",
            "addressStreet": "Test Street",
            "addressNumber": "1234",
            "zipcode": "123456789"
        },
        "relationships": {
            "customer": {
                "data": {
                    "type": "customers",
                    "id": "1"
                }
            },
            "products": {
                "data": [
                    {
                        "type": "products",
                        "id": "1",
                        "quantity": 2
                    }
                ]
            }
        }
    }
}'
````
---

### GET Order
````
GET
curl --location 'http://localhost:61000/api/v1/orders/{orderID}'
--header 'Accept: application/vnd.api+json'
--header 'Content-Type: application/vnd.api+json'
````
