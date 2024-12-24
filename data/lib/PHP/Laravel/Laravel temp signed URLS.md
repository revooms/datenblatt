```
use Illuminate\Support\Facades\URL;

return URL::temporarySignedRoute(
  'email/verify', now()->addMinutes(30), ['user' => 1]
);
```

```
use Illuminate\Http\Request;

Route::get('/email/verify/{user}', function (Request $request) {
    if (!$request->hasValidSignature()) {
        abort(401);
    }

    // ...
})->name('unsubscribe');
```