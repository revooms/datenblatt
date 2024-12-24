In `routes/web.php`:
```
if (App::environment('local')) {
    Route::get('login/{id}', function ($id) {
        $authUser = auth()->loginUsingId($id);
        return redirect(route('profile.show', ['userslug' => $authUser->slug]))->with('message', 'Auto-logged-in');
    });
}
```