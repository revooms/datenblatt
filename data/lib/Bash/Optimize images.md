Recursively optimize JPEGs

```bash
find . -name '*.jpg' -exec jpegoptim -p {} \;
```