```javascript
var id;
$(window).resize(function() {
  clearTimeout(id);
   id = setTimeout(doneResizing, 500);
});
function doneResizing() {
  console.log("done resizing");
}
```