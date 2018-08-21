A simple CMS based on Laravel 5.6 framework
===
As a part of my learning Laravel framework.
***
How to use
-----
1. Install the php(at least 7.1) and the web server(like Apache, Nginx, etc.).
2. Install the [composer](https://github.com/composer/composer).
3. Clone the project, and configure the web server properly.
4. Install the dependencies(Laravel framework, dev tools, etc.). Just run the commands:
> cd PATH-TO-THE-PROJECT
>
> composer install

5. Configure the .env file. It's explained by the Laravel documentation.
6. Make the database. To simplify the instuction, you can use the following steps:
> cd PATH-TO-THE-PROJECT
>
> php artisan migrate:fresh
>
> php artisan db:seed

By default, there is a supreme role and a user of the role in the database. *The default user name of the user is admin and the same as password.
***
Something I want to say
-----
1. The project has much Chinese as I am a Chinese. I'm learning how to internationlize the project elegantly. You could use Google translation to get my point. Don't worry all the comment parts in it is in English, just some frontend parts are in Chinese. However, as you might have seen, I am poor at English.
2. I think the code is very ugly. Or I didn't get the writer of the framework's soul. If you have something want to say or can told me how to write beautyful code. You can contact me directly. And I am glad to communicate to you, from all over the world. The E-mail is shown in my Github page.
