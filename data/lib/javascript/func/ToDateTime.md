Requires: [[MinPad]]

```javascript
function toDateTime(ts) {
	let date = new Date(ts*1000);
  
    return(
  	date.getDate()+
          "."+(date.getMonth()+1)+
          "."+date.getFullYear()+
          " "+date.getHours()+
          ":"+minPad(date.getMinutes()));
}
```