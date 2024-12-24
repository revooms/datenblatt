```
$postCount = Cache::remember(
        'count.posts.' . $user->id,
        now()->addSeconds(30),
        function () use ($user) {
            return $user->posts->count();
        });
```