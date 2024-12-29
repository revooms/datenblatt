
```sas
@for $i from 1 through 8 {
  .card:nth-child(#{$i}n) {
    top: $i * 20px;
  }
}
```