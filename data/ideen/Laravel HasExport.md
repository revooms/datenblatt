---
tags:
- development
- php
- laravel
---

# Laravel HasExport

- Trait, der einem Model den Export in verschiedene Formate erlaubt (ähnlich toJson(), toArray())
	- toRss()
	- toXml()
	- toOpml()
	- toBookmarkHtml()
- Die verfügbaren Exporter werden in einer Config-Datei angegeben
- Der Benutzer muss "ExporterMaps" erstellen, ähnlich [Laravel Resources](https://laravel.com/docs/10.x/eloquent-resources#introduction)

User.php
```php
<?php

namespace App\Models;

class Post extends Model
{
	use HasExport;

	public function toRss()
	{
		return new PostToRssMap($this);
	}
}
```

PostToRssMap.php
```php
<?php
 
namespace App\ExportMaps;
 
class PostToRssMap extends ExportMap
{
    /**
     * Transform the resource into an RSS feed.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
```