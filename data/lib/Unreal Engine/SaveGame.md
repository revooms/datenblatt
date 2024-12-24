https://forums.unrealengine.com/t/proper-way-to-save-various-game-settings/417210/2

[Chromarict](https://dev.epicgames.com/community/api/user_profiles/tab-redirect/about?discourse_username=Chromarict) [Feb 2018](https://forums.unrealengine.com/t/proper-way-to-save-various-game-settings/417210/2 "Post date")

Some settings are saved by the engine when you use the Game User Settings nodes for setting things like overall quality settings and resolution, but this is really just for graphics settings. Some graphics settings have to be applied through console commands via the Execute Console Command node, and other non-graphics settings are almost completely inaccessible to Blueprints at the moment. Additionally, settings that are more specific to one game for gameplay reasons (stuff like show all ally players as one color and all enemy players as another) require a custom method for saving and loading.

Luckily, we have just such a thing: the SaveGame class! While the name implies it’s used to specifically save the game, it can be used to save _nearly anything_ you’d like to a binary file that can be loaded later on. You can either have one catch-all save file for all your game settings, or divide them up into multiple SaveGame classes for more organization. For this example I’m just going to do one save for all the settings to give you a general idea. I’m also going to assume you’re doing this via Blueprints, but it can similarly be done in C++ if needed.

So, start off by creating a new Blueprint based on the SaveGame class. I’m going to call mine BP_SettingsSave. Now when you open this, all you have to do is add variables for each setting you want to save, no node work required. If using a single save for all of your settings, I recommend categorizing your variables by type. I usually do Graphics / Audio / Input / Gameplay. While you’re here, you should go ahead and set default values for these variables for when the save file can’t be loaded (either due to an error or fresh game install with no saved settings).

Once you have these setup, you’re done inside the SettingsSave class. Up next, we’ll add saving and loading functionality. This is best to be done in your GameInstance for your game since the GameInstance is created at launch, persists through the entirety of your game, and doesn’t go away until the game shuts down. This makes it an ideal place to handle saving and loading game settings since just about anywhere you can use a GetGameInstance node to access the settings. If you don’t already have a GameInstance class for your project, go ahead and make one. I’m going to call mine BP_CustomGameInstance.

Inside this class, create a new variable (mine is just named Settings) will hold an object reference of the settings save class you just made. For my example, this will be the BP_SettingsSave from the previous step. Then create a string variable that will hold the slot name of the settings save. I named mine SettingsSlot and set the value to “Settings”. This will be used to save and load the settings from a file in the Project/Saved/SaveGames folder.

Next, create a function and name it something like LoadSettings. This function will only _load_ the saved settings, not apply them. Inside this function, add a Load Game from Slot node and link the slot name variable into the Slot Name input. Then take the output, which is a basic SaveGame object, and cast it to our Settings SaveGame. In my case, I cast to BP_SettingsSave. For the successful execution pin, we set the Settings variable to the As SettingsSave output. On the Failed pin, add a Save Game to Slot, which we use to write the current default values stored in Settings to the settings save file. I added an additional check after that to print a string to screen if that fails. Here’s what your LoadSettings should look like now:

[![230598-load-game-settings.png](https://d3kjluh73b9h9o.cloudfront.net/optimized/4X/b/3/4/b34eaebdcd5dca4f30b82f6f0e7703f49d00e8d4_2_690x228.png)

230598-load-game-settings.png1629×540 117 KB

Up next, we create our SaveSettings function. This one is even simpler: all we need to do is use a Save Game to Slot node on our Settings save variable and enter our slot name. You can add an extra check using the bool output to print a message if it fails, but it hopefully won’t. Here’s the final setup for this function:

[![230600-save-game-settings.png](https://d3kjluh73b9h9o.cloudfront.net/optimized/4X/d/9/0/d90ffb110d1927a052519e4434b1acf18393f625_2_690x210.png)

230600-save-game-settings.png1029×314 60.2 KB


The last thing you need to do in the custom GameInstance class is actually trigger the load on startup and save on shutdown. For that, we head to the Event Graph and add the Event Init and connect it to a LoadSettings node, then add the Event Shutdown node and connect it to a SaveSettings node. This is what the setup should look like:

![230603-load-and-save-settings.png](https://d3kjluh73b9h9o.cloudfront.net/original/4X/8/b/0/8b08258c9691d686b725b8f13cabde20d6a7353b.png)

We’re now done with saving and loading! The final part we need to cover is how to access and modify these values from anywhere. This can be done by using a Get Game Instance node, casting it to your custom Game Instance, and then accessing the Settings variable to either set or get the values in it. Here’s an example of how to set one of the values:

[![230601-set-game-setting.png](https://d3kjluh73b9h9o.cloudfront.net/optimized/4X/b/b/0/bb049705e1d3a7c5e70503e479cfee7cad014729_2_690x137.png)

230601-set-game-setting.png1126×224 60.8 KB

And how to get a game setting:

[![230602-get-game-setting.png](https://d3kjluh73b9h9o.cloudfront.net/optimized/4X/9/b/2/9b24401129847a93bc811aeaac040fd7e0c4b65b_2_690x137.png)

230602-get-game-setting.png1094×218 57.2 KB

You may be wondering why I had you create the save and load functions instead of just building them directly in the event graph. I did it this way so you can save and load the settings anywhere you can access the game instance. For example, say you have an apply button in your settings menu. You wouldn’t want to wait to save the new settings until shutdown in case you crash, so instead you can now call your SaveSettings function anywhere you can use Get Game Instance, such as when you click Apply in the settings menu.

That should be all you need to get saving and loading set up. Actually applying the settings is more dependent on what settings you’re trying to apply and if I went into more detail on it this post would be way too long (some settings are handled by GameUserSettings, some can only be done via console commands, and some require custom C++ to access right now). Basically the general idea for how to apply game settings would be add another function to your game instance called ApplySettings where you handle applying the settings from your Settings save variable. Then you just call this after your initial LoadSettings call in the event graph, as well as after you change settings in your settings menu.
