```gdscript
func getRandomVectorBetween(minVector: Vector3, maxVector: Vector3) -> Vector3:
	var x = rand_range(minVector.x, maxVector.x)
	var y = rand_range(minVector.y, maxVector.y)
	var z = rand_range(minVector.z, maxVector.z)
	var v = Vector3(x,y,z)
	return v
```