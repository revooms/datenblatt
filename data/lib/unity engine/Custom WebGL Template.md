https://www.bytescrafter.net/education/how-to-create-your-own-unity-webgl-export-template/

Searching the Unity application files, we can find the files the default templates are based off: `PlaybackEngines` > `WebGLSupport` > `BuildTools` > `WebGLTemplates`. Fortunately using they’re in the exact structure we need to use for our projects.

### Setting Up Your Template

You can either just copy the whole folder we’ve found from the application files into your assets and figure it out from there, or here are the specific steps:

- Create a folder in your project assets called “WebGLTemplates”
- Create a folder inside that one for your template “MyTemplate” or whatever.
- Create the index.html file for your template.
- Go to `Edit` > `Project Settings` > `Player`, On the `WebGL` tab > `Resolution and Presentation` (or Publishing Settings in older versions) and choose your new template (If it doesn’t appear, try restarting Unity).

WebGL index.html Template Fields

`%UNITY_WEB_NAME%` – Product name defined under player settings
`%UNITY_HEIGHT%` – Height from WebGL Resolution and Presentation in Player Settings
`%UNITY_WIDTH%` – Width from WebGL Resolution and Presentation in Player Settings
`%UNITY_WEBGL_LOADER_GLUE%` – The code that loads your build, this usually goes in just before the body closing tag.

Hints and Pitfalls

- using a .php index file doesn’t seem to work yet.
- If you create a 128×128 thumbnail.png in the folder of your template, it will show up in the Unity WebGL template selection of your player settings, just like with web player templates!
- If you’re working off the Unity default template, the most useful file to edit is the `unityProgress.js` – you can smooth out the motion of the preloader, and move out some of the code to html instead.