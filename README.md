##Laravel пакет для сквозной аутентификации и авторизации.

###Установка
Для установки в консоле пишем следующее:

`composer req shop25/auth:dev-master --prefer-source`

В файле config/app.php подключить сервис провайдер /S25/Auth/ThroughAuthServiceProvider

В командной строке в корне проекта выполняем команду

`php artisan vendor:publish --provider="S25\\Auth\\ThroughAuthServiceProvider"`

Далее в файле config/auth.php меняем 
```      
'api' => [
    'driver' => 'token',
    'provider' => 'users'
],
```

на 

```      
'api' => [
    'driver' => 'jwt',
    'provider' => 'users',
    'hash' => false,
],
```

и меняем 

```      
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => User::class,
    ],
],
```

на

```      
'providers' => [
    'users' => [
        'driver' => 'redis',
        'model' => S25\Auth\User::class,
    ],
],
```

В файле app/Http/Kernel.php заменяем мидлварь auth на \S25\Auth\Middleware\Authenticate::class

Добавляем в .env следующие переменные

JWT_SECRET=текущий код для генерации jwt

AUTH_SERVICE=url авторизационного сервиса




