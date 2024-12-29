Die Standard-Benutzer-Seeder
```
\App\Models\User::factory()->create([
	'name' => 'Admin',
	'email' => 'admin@local',
	'password' => Hash::make('adminadmin'),
]);
\App\Models\User::factory()->create([
	'name' => 'User',
	'email' => 'user@local',
	'password' => Hash::make('useruser'),
]);
\App\Models\User::factory()->create([
	'name' => 'Guest',
	'email' => 'guest@local',
	'password' => Hash::make('guestguest'),
]);
```

package.json scripts:
```
"scripts": {
	"dev": "vite",
	"build": "vite build",
	"fresh": "php artisan migrate:fresh --seed",
	"serve": "php artisan serve",
    "broadcast": "php artisan reverb:start",
    "queue": "php artisan queue:work",
	"scheduler": "php artisan schedule:work"
},
```

Seed With Relation:
```
factory(App\Customer::class, 10)->create()->each(function ($customer) {
	// Seed the relation with one address
	$address = factory(App\CustomerAddress::class)->make();
	$customer->address()->save($address);

	// Seed the relation with 5 purchases
	$purchases = factory(App\CustomerPurchase::class, 5)->make();
	$customer->purchases()->saveMany($purchases);
});
```