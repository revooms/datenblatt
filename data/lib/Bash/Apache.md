# "Unique Views" aus dem access.log
`awk '{print $4}' access.log | cut -d: -f1 | uniq -c`

