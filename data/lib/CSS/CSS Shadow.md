---
tags:
  - calendar
  - laravel
  - app
  - css
  - shadow
  - hsl
title: foobar
release_date: 2022-01-12
categories: ["Test", "Tettttss2"]
---

Via https://www.joshwcomeau.com/css/introducing-shadow-palette-generator/

```
.red-box {
  --shadow-color: 0deg 100% 50%;
  background-color: hsl(var(--shadow-color));
}
```

> Here's the really cool bit: HSL also accepts an optional fourth parameter for opacity. hsl(0deg 100% 50% / 0.5) is the same bright red color, but only 50% opaque.
> 
>(The / character is a delimiter. It's becoming a common pattern in modern CSS, used to create groups of values. It has nothing to do with division.)