# Admin panel for Laravel 5.4

**This package require this packages:**

```
composer require keyhunter/multilingual dev-master
composer require keyhunter/translatable dev-master
```
install this packages **before** installing ``` keyhunter/administrator ```

## Intallation

- Install the package:

```
composer require keyhunter/administrator dev-master
```

- Add **ServiceProvider.php** to the ``` $providers ``` in *{root_project}\config\app.php* :

```
'providers' => [
    // ...
    Keyhunter\Administrator\ServiceProvider::class
];
```

-Update **AppServiceProvider** from App\Providers\AppServiceProvider **use Illuminate\Support\Facades\Schema;** 
-place in public function boot() :

```
 Schema::defaultStringLength(191);
```

- Remove **DatabaseSeeder.php** from *{root_project}\database\seeds*
and remove **create_users_table** from *{root_project}\database\migrations* if exists and publish files from ``` /vendor ``` :

```
php artisan vendor:publish
```

- Run this command:
```
composer dump-autoload
```

- Migrate the required tables:

```
php artisan migrate
```

- Seed the initial data to tables:

```
php artisan db:seed
```

- Go to ```App\User::class``` and change:

**from:**
```
use Illuminate\Foundation\Auth\User as Authenticatable;
```
**to:**
```
use Keyhunter\Administrator\AuthRepository as Authenticatable;
```

- Done. Now go to ``` localhost\admin ``` to login use:
```
  login: admin@admin.com
  pass: admin123
```
