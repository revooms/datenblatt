via https://ezcha.net/news/3-1-23-custom-resources-are-op-in-godot-4
# Custom Resources are OP in Godot 4

Using custom resources in Godot has been a massive game changer for me. With Godot 4.0 just being released what could be a better time to share a guide? Recently, a friend of mine who also uses Godot asked how I was handling the customization options in my game [EzGuy Creator](https://ezcha.net/games/ezguy-creator). I explained that I was using custom resources. After this he told me he was not aware they were a thing, so naturally I decided on that as the topic of a guide. In this post I will be going over what resources in Godot are exactly, how they work and when/how to make your own.

_**Note:** This guide is written for Godot 4. The included examples and script snippets will not work in Godot 3.x versions._

---

## What exactly is a resource?

A resource in Godot is an object that represents data and properties. A resource and its data can be saved to and loaded from files. Godot's documentation refers to them as data containers. When you import images, sounds, fonts and models they become resources. You can see all the types of resources Godot offers in the [documentation](https://docs.godotengine.org/en/stable/classes/class_resource.html). They can keep track of multiple values, references to other resources and can contain functions to manipulate its data. After a resource is loaded, the engine will cache it as long as you keep a reference to it. This can improve performance if the same resources are requested multiple times. The best part is that you can create your very own resource classes!

![A gif displaying the create resource window in Godot 4](https://ezchacdn.com/ezcha3/news/godot4-resources-are-op/resource-list.gif)

## Why Custom Resources Classes Are So Useful

It can be very convenient and useful to create your own resource class for several reasons. Compared to something like dictionaries or arrays, they offer a much more structured and organized way to keep track of data. Resources have all of their properties and their types predefined. When you edit a resource its properties are shown and are able to be manipulated in the Godot editor's inspector dock. Resources can also be saved and loaded to/from files, making management of all this data very easy and simple.

![An image showing a custom resource in Godot's inspector dock](https://ezchacdn.com/ezcha3/news/godot4-resources-are-op/inspector-example.png)

This is an advertisement. Get [Ezcha Elite](https://ezcha.net/elite) to remove ads.

## When You Should Use Them

There are many use cases for custom resources. Specific examples may include saving/storing item information such as descriptions and textures, item systems, player save data, random level generator options and much more. It is better to use custom resources to store data compared to nodes. They are much more lightweight and will consume less processing time and memory, increasing your game's performance.

---

## Creating a Custom Resource Class

To get started making your own resource class you will need to create a script that extends the base `Resource` class.

![A gif showing the script creation window](https://ezchacdn.com/ezcha3/news/godot4-resources-are-op/create-resource.gif)

You can also give a custom name to the class the script represents. It is not required but it can come in handy for checking types and other things. To give it a name, make a new line that begins with `class_name` followed by the name you want to give it.

```gdscript
extends Resource
class_name CharacterAttributes
```

Now you can define its properties/values! They work just like any other variable in gdscript, except you prefix it with `@export`. This is called an annotation, which are new to Godot 4. Exporting a variable will allow you to edit its value in the editor's inspector tab when you use your resource. You need to either specify the type of the variable or give it an initial value so the type can be inferred. I recommend specifying the type. Exporting variables is not exclusive to resources. This works with any script/node and is a great way to specify scene-specific values.

```gdscript
@export var title: String = ""
@export var first_name: String = "Person"
@export var last_name: String = "McHuman"
@export var invulnerable: bool = false
@export var overworld_texture: Texture
```

This is an advertisement. Get [Ezcha Elite](https://ezcha.net/elite) to remove ads.

_**Fun fact:** Specifying the type of your variables can speed up your game! It allows Godot to do some optimizations when running your scripts. Check out some numbers from a recent update [here](https://github.com/godotengine/godot/pull/70838)._

You can also give it functions just like any other script. These can be helper functions to manipulate the resource's properties.

```gdscript
func has_title() -> bool:
	return (title != "")

func get_full_name() -> String:
	if (title == ""):
		return "%s %s" % [first_name, last_name]
	return "%s %s %s" % [title, first_name, last_name]
```

Here is our final result, a custom resource class.

```gdscript
# character_attributes.gd
extends Resource
class_name CharacterAttributes

@export var title: String = ""
@export var first_name: String = "Person"
@export var last_name: String = "McHuman"
@export var invulnerable: bool = false
@export var overworld_texture: Texture

func has_title() -> bool:
	return (title != "")

func get_full_name() -> String:
	if (title == ""):
		return "%s %s" % [first_name, last_name]
	return "%s %s %s" % [title, first_name, last_name]
```

## How To Use And Save Your Resource

Now that you have set up your custom resource class you can now use it! There are two ways to create a new resource. There is a button in the inspector dock, or you can right click a directory/folder in the file browser and use the context menu.

![Godot's inspector dock with the create resource button circled](https://ezchacdn.com/ezcha3/news/godot4-resources-are-op/create-resource-button.png)

![Godot's file browser with the "create" context menu opened](https://ezchacdn.com/ezcha3/news/godot4-resources-are-op/file-system-create-resource.png)

This is an advertisement. Get [Ezcha Elite](https://ezcha.net/elite) to remove ads.

You will be greeted by a window containing a list of resource classes to choose from along with a search box.

![Godot's inspector panel with the create resource button circled](https://ezchacdn.com/ezcha3/news/godot4-resources-are-op/create-resource-window.png)

After you select and create your resource it will be displayed inside the inspector dock. Here you are able to see and manipulate its properties. Once you are done, you can save the resource by pressing the save button or with the trusty old `CTRL+S` keyboard shortcut.

![Godot's inspector panel with the save resource button circled](https://ezchacdn.com/ezcha3/news/godot4-resources-are-op/save-resource-button.png)

## Loading And Referencing Your Resource

It should now be fairly simple to load and reference our resource. There are four different ways you can do this. This guide will be going over three of them, skipping over the [ResourceLoader](https://docs.godotengine.org/en/stable/classes/class_resourceloader.html) class because it's not as straight forward as the others. The way I usually find myself loading resources is by adding a `@export` variable in the class that needs it. Just like when you make a custom resource, this tells Godot to show the variable as a property in the inspector dock when the class is selected. This allows you to to quickly define and update the resource it references.

```gdscript
# character.gd
extends CharacterBody2D
class_name Character

signal damage_taken
signal death

@export var attributes: CharacterAttributes :
	set(value):
		attributes = value
		sprite.texture = value.overworld_texture
@export var health: int = 100

@onready var sprite: Sprite2D = $Sprite

func _ready():
	print("Hello! My name is %s." % [attributes.get_full_name()])

func damage(amount: int):
	if (attributes.invulnerable): return
	health -= amount
	if (health > 0):
		emit_signal("damage_taken", amount)
		return
	emit_signal("death")
```

Alternatively, you can use both `preload` and `load` to get your resource without all the fancy editor stuff.

```gdscript
const ATTRIBUTES_LIST: Array[CharacterAttributes] = [
	preload("res://objects/character/attributes/john_doe.tres"),
	preload("res://objects/character/attributes/jane_doe.tres")
]
```

This is an advertisement. Get [Ezcha Elite](https://ezcha.net/elite) to remove ads.

```gdscript
func _ready():
	attributes = load("res://objects/character/attributes/jane_doe.tres")
```

---

## Extra Tips & Tricks

As this guide comes to a close, there are a few extra tips and tricks you may want to know about. This includes an explanation on how Godot caches/shares resources to reduce memory usage, and how that can occasionally cause a certain issue. However there is way to fix this. Another tip is that there are other annotations that can be used in place of `@export` that can indicate more specific values. The full list of annotations can be found in Godot's documentation and I have included some examples as well.

### Local To Scene

Say we have a new scene called **Box** containing a **MeshInstance3D** node. There's a point to this, I promise. We give this node a cube mesh and set its `material_override` property to a new **StandardMaterial3D** resource. Now we go to a separate scene and instance **Box** several times. Godot will create a singular copy of the resources **Box** uses and will share it across all of its instances. This is great for performance, but you may find yourself having a certain issue. Go back to our **Box** scene. We need the mesh to change its color to red when interacted with, so we give it a script that sets the `albedo_color` property of the mesh's material. When we run the other scene and interact with one **Box** you will quickly realize all the other instances change colors too! However, there is a solution to this. You can find a "local to scene" property in the inspector for every resource. When this is enabled Godot will make the resource unique in every scene it is instanced in. At the cost of some memory usage and drawing performance, we can now change the color of each **Box** individually.

![An image showing the "local to scene" property in the inspector](https://ezchacdn.com/ezcha3/news/godot4-resources-are-op/local-to-scene.png)

### Additional Export Annotations

There are several additional types of export annotations. While the standard `@export` will work in most cases, you can use the additional annotations to indicate more specific values. You can export file paths, multi-line strings, enum strings, add categories and more! The full list of annotations can be found [here](https://docs.godotengine.org/en/stable/classes/class_%40gdscript.html#annotations) in Godot's documentation. Below is a small, handpicked list of annotations I believe to be some of the most useful. I have included their descriptions and examples from the documentation.

#### @export_category ( String name )

```gdscript
# Define a new category for the following exported properties.
# This helps to organize properties in the Inspector dock.
@export_category("Statistics")
@export var hp = 30
@export var speed = 1.25
```

This is an advertisement. Get [Ezcha Elite](https://ezcha.net/elite) to remove ads.

#### @export_file ( String filter="", ... )

```gdscript
# Export a String property as a path to a file.
# The path will be limited to the project folder and its subfolders.
# See @export_global_file to allow picking from the entire filesystem.
# If filter is provided, only matching files will be available for picking.
@export_file var sound_effect_path: String
@export_file("*.txt") var notes_path: String
```

#### @export_multiline ( )

```gdscript
# Export a String property with a large TextEdit widget instead of a LineEdit.
# This adds support for multiline content and makes it easier to edit large amount of text stored in the property.
@export_multiline var character_biography: String
```

#### @export_range ( float min, float max, float step=1.0, String extra_hints="", ... )

```gdscript
# Export an int or float property as a range value.
# The range must be defined by min and max, as well as an optional step and a variety of extra hints.
# The step defaults to 1 for integer properties.
@export_range(0, 20) var number: int
@export_range(-10, 20) var number: int
@export_range(-10, 20, 0.2) var number: float
```

---

## Thank you!

Thank you for making it to the end of my guide about resources in Godot 4. If this has been helpful, you can support me by checking out the rest of my website! It has [games](https://ezcha.net/games), some [devlogs](https://ezcha.net/news/search?series=scribble-surfer-devlogs) about my game Scribble Surfer, and even [forums](https://ezcha.net/forums) that include a game dev section. 👋