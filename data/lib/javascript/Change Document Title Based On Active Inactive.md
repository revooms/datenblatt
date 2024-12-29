```javascript
let activeTitle = 'You have 6 items';
let inactiveTitle = 'Please come back';
document.title = activeTitle;
window.addEventListener('blur', e => {
    document.title = inactiveTitle;
});
window.addEventListener('focus', e => {
    document.title = activeTitle;
});
```

via https://christianheilmann.com/2022/02/10/showing-different-titles-depending-if-the-tab-is-active-or-not/