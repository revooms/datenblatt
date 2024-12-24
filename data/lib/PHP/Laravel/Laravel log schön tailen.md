https://superuser.com/questions/188865/how-to-make-bash-not-to-wrap-output
More portably: `tput rmam; ls -l longname; tput smam`


```bash
tput rmam;nl storage/logs/laravel.log | tail -n 50 -fz; tput smam
```
