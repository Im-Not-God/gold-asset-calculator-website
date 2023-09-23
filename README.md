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
  - database config<br>![image](https://github.com/Im-Not-God/gold-asset-calculator-website/assets/82208147/16b37c59-05f9-4077-be11-d77b1397500a)
  - mail config (you are supposed to change this account to your own)<br>![image](https://github.com/Im-Not-God/gold-asset-calculator-website/assets/82208147/8791e5dd-333a-449e-b77b-a2db0ad1d846)
    <br>how to make this -> https://support.google.com/accounts/answer/185833?hl=en
  - or other part...


- Run <code>php artisan key:generate</code>
- Run <code>php artisan serve</code>
- Go to http://localhost:8000/

## Database
- The database data file is <b>fyp.sql</b>

## Limitations and future development recommendations for different aspects of the project:
#### 1. Login/Register:
  - Implement third-party login options (e.g., Google) in the login/register system.
  - Add a "view password" function to enhance user experience.
  - Provide password format hints to help users understand valid password formats.
#### 2. Search Functionality:
  - Implement a search function for easy data retrieval.
#### 3. User Profiles:
  - Create user profiles with the ability to change usernames, passwords, check billing information, enhance security (e.g., two-factor authentication), link third-party accounts and delete account.
#### 4. Contact and About Pages:
  - Add "Contact Us" and "About Us" pages to provide additional information and support.
#### 5. Localization, UI and User Experience:
  - Implement a toast notification bar for timely information updates.
  - Ongoing localization efforts to cover more languages.
  - Utilize Ajax for updating certain data to improve the overall user interface.
#### 6. Mobile App Support:
  - Create APIs to support mobile app integration.
#### 7. Report list:
  - Develop a report list page to show all report that generated before.
  - Implement the ability to save reports in PDF format and store them in the database.
#### 8. Billing System:
  - Develop a billing system with options like FPX.
#### 9. Admin Panel:
  - Allow admin users to add new subscription plans and delete subscription plans.
  - Develop an admin dashboard to show website data(number of user, user subscription, …) for easier site management.
#### 10. Legal Compliance:
  - Provide terms of use and policies to ensure legal compliance.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
