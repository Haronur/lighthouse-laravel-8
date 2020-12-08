<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Installing Lighthouse
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://lighthouse-php.com/assets/img/flow.f9dcf86d.png"></a></p>
### Memory limit errors
- Try increasing the limit in your `php.ini` file (ex.` /etc/php5/cli/php.ini` for Debian-like systems):

```
; Use -1 for unlimited or define an explicit value like 2G
memory_limit = -1
```
- Of course, we will use Lighthouse as the GraphQL Server.

```composer require nuwave/lighthouse```

- In this tutorial we will use GraphQL Playground as an IDE for GraphQL queries. It's like Postman for GraphQL, but with super powers.

```composer require mll-lab/laravel-graphql-playground```

- Then publish default schema to `graphql/schema.graphql`.

```php artisan vendor:publish --tag=lighthouse-schema```

- Consult the Laravel docs on database configuration and ensure you have a working database set up.
#### Create Database at phpMyAdmin named `lighthouse-laravel-8` and setup `.env` file in your root directory 

- Database
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lighthouse-laravel-8
DB_USERNAME=root
DB_PASSWORD=
```

- Run database migrations to create the users table:
```
php artisan migrate
```
- Seed the database with some fake users:
```
php artisan tinker
\App\Models\User::factory()->count(30)->create();
``` 
- To make sure everything is working, access Laravel GraphQL Playground on `http://127.0.0.1:8000/graphql-playground` and try the following query:
```
{
  user(id: 1) {
    id
    name
    email
  }
}
```
- Now, let's move on and create a GraphQL API for our blog.

## -- Run Command to Create Some Files --
- Run below command to create all files below

```
php artisan make:model -m Post
php artisan make:model -m Comment
```
##  Create Factory & Seeder Files to Generate dummy data
```
php artisan make:factory PostFactory --model=Post
php artisan make:factory CommentFactory --model=Comment

php artisan make:seeder PostSeeder
php artisan make:seeder CommentSeeder
``` 
## -- Generate dummy data in Laravel 8 using Model Factory --
#### Customize Some files for Generate dummy data in Laravel 8 using Model Factory
#### Finally run those below command:
```
php artisan migrate:refresh
php artisan db:seed
```
- And Check your Database table in my case at `phpMyAdmin` named  `lighthouse-laravel-8`(it has some seeded data for your testing)

### The Models

- This first part will show you how to set up the models and database migrations and does not include any specifics related to GraphQL or Lighthouse.

- Our blog follows some simples rules:
```
-  a user can publish multiple posts
-  each post can have multiple comments from anonymous users
```
- We can model this in our database schema like this.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://lighthouse-php.com/assets/img/model.08d79f32.png" width="500"></a></p>

**Database relations diagram*
###  Begin by defining models and migrations for your posts and comments

- Replace the newly generated `app/Models/Post.php` with this below:
``` php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
```
and the `create_posts_table.php` with this below:
``` php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->string('title');
            $table->string('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
```
### Let's do the same for the Comment model:
-Replace the newly generated `app/Models/Comment.php` with this below:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
```
and the `create_comments_table.php` with this below:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('reply');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
```
- Remember to run the migrations:
``` sh
php artisan migrate
```
### Finally, add the `posts` relation to `app/User.php`
like below:
``` php
<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id');
    }
}
```

### The Schema
- Let's edit `graphql/schema.graphql` and define our blog schema, based on the `Eloquent models` we created.
- We add two queries for retrieving posts to the root `Query` type:
```
type Query {
  posts: [Post!]! @all
  post(id: Int! @eq): Post @find
}
```
- The way that Lighthouse knows how to resolve the queries is a combination of convention-based naming - the type name `Post` is also the name of our Model - and the use of server-side directives.

    `@all` returns a list of all Post models
    `@find` and `@eq` are combined to retrieve a single `Post` by its ID

- We add additional type definitions that clearly define the shape of our data:
``` php
type User {
  id: ID!
  name: String!
  email: String!
  created_at: DateTime!
  updated_at: DateTime!
  posts: [Post!]! @hasMany
}

type Post {
  id: ID!
  title: String!
  content: String!
  author: User! @belongsTo
  comments: [Comment!]! @hasMany
}

type Comment {
  id: ID!
  reply: String!
  post: Post! @belongsTo
}
```
- Just like in Eloquent, we express the relationship between our types using the `@belongsTo` and `@hasMany` directives.

### The Result
- Insert some fake data into your database, you can use Laravel seeders for that.(We already created)
- Visit `/graphql-playground` and try the following query:
``` php
{
  posts {
    id
    title
    author {
      name
    }
    comments {
      id
      reply
    }
  }
}
```
- You should get a list of all the posts in your database, together with all of its comments and the name of the author.
- Hopefully, this example showed you a glimpse of the power of GraphQL and how Lighthouse makes it easy to build your own server with Laravel.