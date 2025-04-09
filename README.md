## Demo

![alt text](https://i.imgur.com/eNRTflK.png)
![alt text](https://i.imgur.com/S9IneSc.png)
![alt text](https://i.imgur.com/rJDsdbz.png)
![alt text](https://i.imgur.com/SXMkYh7.png)
![alt text](https://i.imgur.com/W0w2Gtl.png)
![alt text](https://i.imgur.com/MXiHjV5.png)

## Setup Instructions

To get started with Laravel Splade, follow these steps:

1.  Install the required dependencies:
    ```php
    composer install
    npm install
    ```

2. Compile front-end assets.
    ```php
    npm run build
    ```

3. Copy the `.env.example` file to `.env`:
    ```php
    cp .env.example .env
    ```

4. Generate a security key and link the storage file:
    ```php
    php artisan key:generate
    ```

5. Import SQL File to Your Database

6.  Configure your database connection by updating the `.env` file.

7. Start server:
    ```php
    php artisan serve
    npm run dev
     ```

## Credentials

Access the login page: [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)

-   Email: [admin@gmail.com](mailto:admin@gmail.com)
-   Password: 123123123
