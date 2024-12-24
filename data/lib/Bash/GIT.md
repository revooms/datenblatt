# git commands

Get/set the url of a remote (if your repository path changes)
```bash
git remote get-url origin
git remote set-url origin [REPOURL]
```

Reset your code back to what is committed, and delete any files that are not known to git
```bash
git reset --hard;git clean -df
```

```bash
git push --set-upstream origin staging
git push https://${gitusername}:${personal_access_token}@gitlab.com:brombeer/webcomponents.git HEAD:staging
```
