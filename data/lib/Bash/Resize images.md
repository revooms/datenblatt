Recursively resize images to a width of 1200

```bash
find . -name '*.jpg' -exec convert -resize 1200 "{}" "{}" \;
```