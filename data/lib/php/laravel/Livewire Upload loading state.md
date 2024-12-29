Via https://stackoverflow.com/questions/67402941/laravel-livewire-refresh-view-before-slow-upload

```php
<form method="POST" wire:submit.prevent="submit">
  @csrf
  <div class="mb-3">
    <x-media-library-attachment name="media" :rules="$mimeTypes" key="mediaLibrary"/>
  </div>
  <input type="submit" class="btn btn-primary btn-bg" />
</form>
<div wire:loading wire:target="submit">
   Loading...
</div> 
```