# Product stock management
## Functionality
1. Import products from json files. Easily extendable to other data formats (XML, Excel, CSV). Use ```command:ImportProduct```
2. Shows all products with counted stock. Command is used automatically by task sechudling. In this case command is launched every minute
3. Show single product, although is cached stock data is provided in the real time
4. Most of functionality is covered by unit and functional tests 
## Installation instructions
1. Use ```copy .env.example .env``` to made copy of ```.env``` file.
2. Use ```php artisan key:generate``` to generate app key.
3. Provide correct DB credentials in .env file.
4. Migrate ```php artisan migrate```.
5. Use ```php artisan serve``` to launch app and ```npm run dev``` on the other terminal instance for front-end changes.
