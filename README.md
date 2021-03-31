## Products and States API

A simple API to get, store, update and delete products and to consume an IBGE third party API. This is a real challenge that implements several Laravel and development practices! See this docs below:

### Technologies used:
- [Laravel](https://laravel.com/)
- [PHPUnit](https://phpunit.de/)
- [Insomnia](https://insomnia.rest/download)
- [Visual Studio Code](https://code.visualstudio.com/)

### Checking it out: 

First you'll need to clone the repo:
```
git clone git@github.com:RafaelEmery/products-and-states-api.git
```

Then run the composer and Laravel commands:
```
composer install

php artisan migrate

php artisan db:seed
```

Don't forget to migrate the testing database:
```
php artisan migrate --env=testing
```

### Tests:

![](/readme-src/tests.png)

I applied some TDD (Test Driven Development) practices to test my application, so i used Unit tests and Feature tests (Integration tests). To run the tests you simply need to run:
```
php artisan test
```

You can test using **./vendor/bin/phpunit** too. Artisan commands are just a personal preference :smiley:

### API Endpoints:
| Description                       | Route                           | Method | Additional info                                                 |
|-----------------------------------|---------------------------------|--------|-----------------------------------------------------------------|
| Get all states                    | api/v1/states                   | GET    | None                                                            |
| Get all products                  | api/v1/products                 | GET    | None                                                            |
| Get one product                   | api/v1/products/{id}            | GET    | Id of product.                                                   |
| Create a product                  | api/v1/products                 | POST   | Need to send on body: 'name', 'type', 'quantity'.               |
| Update a product                  | api/v1/products/{id}            | PUT    | Id of product Need to send on body: 'name', 'type', 'quantity'. |
| Delete a product                  | api/v1/products/{id}            | DELETE | Id of product.                                                   |
| Increment quantity of one product | api/v1/products/{id}/increments | PUT    | Need to send on body: 'quantity'.                               |

### Body example:
To create and update a product you'll need to send a request (POST or PUT) with a body. I made some additional validation so the types must be:
```php
$dataExample = [
    'name' => 'Sabão em pó', //required|string
    'type' => 'Limpeza', //required|string
    'quantity' => 5 //required|integer|min:0
];
```

### Seeder consuming IGBE API:
At class **StateSeeder** in order to fill database with all Brazil's states, it consumes using Laravel Http Client the IBGE API. So you just need to run the seeds and yout 'states' table will have all 27 states.

### Other informations and features:
- I used Insomnia for testing the API routes.
- **ResourceCollection** and **JsonResource** classes to API's response.
- Added some basic validation to products data.
- Also created a method to increment (or decrement) the quantity of product.
- Database seeding and **Factory** classes (using Faker) for testing cases.
- Laravel simple **Http Client** to make GET requests to third party IBGE API.
- Semantic commits to improve project organization at versions.
