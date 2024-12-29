### Code

```php
if (App::environment(['local', 'staging'])) {
    //code goes here 
}

// or 

if (app()->environment(['local', 'staging'])) {
    //code goes here
}
```

### Blade

```php
@if(App::environment('production'))
    {{-- in "production" environment --}}
@endif
```

```php
@production
    {{-- in "production" environment --}}
@endproduction
```

```php
@env('local', 'staging')
    {{-- in "local" or "staging" environment --}}
@endenv
```