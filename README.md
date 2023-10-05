<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About Laravel Framework

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications. [Learn more](https://laravel.com/)

## Installation
- Download this project
- Go to the folder application using cd command on your cmd or terminal
- Run <code>composer install</code>on your cmd or terminal
- Copy <b>.env.example</b> file to <b>.env</b> on the root folder. You can type <code>copy .env.example .env</code> if using command prompt Windows
- Open your <b>.env</b> file and change the following fields to match your configuration.
  - database config<br>![image](https://github.com/Im-Not-God/gold-asset-calculator-website/assets/82208147/baee0cff-2609-404e-abde-8f8c3280d979)
  - mail config (you are supposed to change this account to your own)<br>![image](https://github.com/Im-Not-God/gold-asset-calculator-website/assets/82208147/bae40a41-e26a-4ec3-b16d-fcb800fbd9cf)
    <br>how to make this -> https://support.google.com/accounts/answer/185833?hl=en
  - or other part...


- Run <code>php artisan key:generate</code>
- Run <code>php artisan serve</code>
- Go to http://localhost:8000/

## Database
- The database data file is <b>fyp.sql</b>

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
