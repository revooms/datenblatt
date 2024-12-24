https://gist.githubusercontent.com/unitycoder/19625fed364a39cb278f/raw/d72689b445cf2f3ffea0b7b90b3b2500d3fcea80/UITextTypeWriter.cs

```c
using UnityEngine;
using System.Collections;
using UnityEngine.UI;

// attach to UI Text component (with the full text already there)

public class UITextTypeWriter.cs : MonoBehaviour 
{

	Text txt;
	string story;

	void Awake () 
	{
		txt = GetComponent<Text> ();
		story = txt.text;
		txt.text = "";

		// TODO: add optional delay when to start
		StartCoroutine ("PlayText");
	}

	IEnumerator PlayText()
	{
		foreach (char c in story) 
		{
			txt.text += c;
			yield return new WaitForSeconds (0.125f);
		}
	}

}
```
