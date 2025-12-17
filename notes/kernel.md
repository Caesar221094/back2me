Register middleware:

Open `app/Http/Kernel.php` and add the middleware alias to `$routeMiddleware`:

```php
'role' => \App\Http\Middleware\EnsureRole::class,
```

This allows routes to use `->middleware('role:superadmin|petugas')`.
