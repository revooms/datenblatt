Requires: [[MinPad]]

```javascript
function toTime(ts) {
	let date = new Date(ts*1000);
    return(date.getHours() + ":" + minPad(date.getMinutes()));
}
```