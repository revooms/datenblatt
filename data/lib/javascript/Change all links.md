
```javascript
window.addEventListener("DOMContentLoaded", e =>
{
  document.querySelectorAll('a[href]').forEach(a =>
  {
    if (location.hostname == new URL(a.href).hostname)
      return;

    a.target = "_blank";
    a.rel = "noreferrer nofollow noopener";
  });
});
```
