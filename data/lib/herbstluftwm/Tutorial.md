![](https://herbstluftwm.org/herbstluftwm.svg)

# herbstluftwm

a manual tiling window manager for X

-   [Overview](https://herbstluftwm.org/index.html)
-   [Documentation](https://herbstluftwm.org/news.html)
-   [FAQ](https://herbstluftwm.org/faq.html)
-   [Download](https://herbstluftwm.org/download.html)
-   [Users contributions](https://herbstluftwm.org/contrib.html)

[News](https://herbstluftwm.org/news.html) [Migration](https://herbstluftwm.org/migration.html) [Tutorial](https://herbstluftwm.org/tutorial.html) [Objects](https://herbstluftwm.org/object-doc.html) [herbstluftwm(1)](https://herbstluftwm.org/herbstluftwm.html) [herbstclient(1)](https://herbstluftwm.org/herbstclient.html)

## Description

This tutorial explains how to create a basic herbstluftwm setup and introduces the major herbstluftwm features. This tutorial neither covers all features nor specifies the mentioned features entirely; see [**herbstluftwm**(1)](https://herbstluftwm.org/herbstluftwm.html) for a compact and more complete description.

This tutorial covers these topics:

-   [Basic installation](https://herbstluftwm.org/tutorial.html#installation)
    
-   [Usage of the client](https://herbstluftwm.org/tutorial.html#client)
    
-   [The tiling method](https://herbstluftwm.org/tutorial.html#tiling)
    
-   [Tags (or workspaces…)](https://herbstluftwm.org/tutorial.html#tags)
    
-   [Multi-Monitor handling](https://herbstluftwm.org/tutorial.html#monitors)
    

## Basic installation

This describes two alternate installation methods. In any case, you also have to install the dependencies. Beside the standard libraries (XLib) which are found on nearly any system, you should install dzen2 (as current as possible) which is needed by the default `panel.sh`.

### Via the package manager

You always should prefer installing herbstluftwm via your package manager on your system. It should be called `herbstluftwm`.

After installing it, the default configuration file has to be copied to your home directory:

```
mkdir -p ~/.config/herbstluftwm
cp /etc/xdg/herbstluftwm/autostart ~/.config/herbstluftwm/
```

You also should activate the tab completion for `herbstclient`. In case of bash, you can either activate the tab completion in general or source the herbstclient-completion from the bash_completion.d directory in your bashrc. In case of zsh the tab-completion normally is activated already (if not, consider activating it).

### Directly from git

If there is no package for your platform or if you want to use the current git version, then you can pull directly from the main repository:

```
git clone https://github.com/herbstluftwm/herbstluftwm
cd herbstluftwm
make # build the binaries

# install files
mkdir -p ~/bin
# you also have to put $HOME/bin to your path, e.g. by:
echo 'export PATH=$PATH:$HOME/bin' >> ~/.bashrc # or to your zshrc, etc...
ln -s `pwd`/herbstluftwm ~/bin/
ln -s `pwd`/herbstclient ~/bin/

# copy the configuration
mkdir -p ~/.config/herbstluftwm/
cp share/autostart ~/.config/herbstluftwm/
cp share/panel.sh ~/.config/herbstluftwm/
```

-   If you are using bash, then source the bash completion file in your `~/.bashrc`
    
    ```
    source path-to/herbstluftwm/share/herbstclient-completion
    ```
    
-   If you are using zsh, then copy the `share/_herbstclient` file to the appropriate zsh-completion directory.
    

Each time there is an update, you have to do the following steps in your herbstluftwm directory:

```
git pull
make
```

## Configure herbstluftwm as your window manager

As usual you can define herbstluftwm as your window manager by either selecting herbstluftwm in your login manager or by starting it in your `~/.xinitrc`, mostly by writing to your xinitrc (or `.xsession` on some systems):

```
# start herbstluftwm in locked mode (it will be unlocked at the end of your
# autostart)
exec herbstluftwm --locked
```

After logging in the next time, you will get a default herbstluftwm session.

## First start

After starting herbstluftwm, the screen is surrounded by a green frame initially, which indicates that there is only one large frame. A frame is a container where actual windows can be placed or which can be split into two frames.

Start an `xterm` by pressing Alt-Return, which will fill your entire screen.

## Using the client

The only way to communicate to herbstluftwm is by using the client application called [`herbstclient`](https://herbstluftwm.org/herbstclient.html). Its usual syntax is: `herbstclient COMMAND [ARGUMENTS]`. This calls a certain `COMMAND` within your running herbstluftwm instance. This causes some effect (which depends on the given `COMMAND` and `ARGUMENTS`), produces some output which is printed by `herbstclient` and lets `herbstclient` exit with a exit-code (e.g. 0 for success) like many other UNIX tools:

```
    shell              COMMANDS,
       ╲ COMMAND,      ARGUMENTS
        ╲ ARGUMENTS ╭────────────╮
         ╲          │            │
          V         │            V
         herbstclient         herbstluftwm
          ╱         ^            │
         ╱ output,  │            │
        ╱ exit-code ╰────────────╯
       V               output,
 shell/terminal       exit-code
```

The most simple command only prints the herbstluftwm version:

```
$ # lines prefixed with $ describes what to type, other lines describe the
$ # typical output
$ # Type: her<tab>c<tab> ve<tab>
$ herbstclient version
herbstluftwm 0.4.1 (built on Aug 30 2012)
$ herbstclient set window_border_active_color red
$ # now the window border turned red
```

The configuration of herbstluftwm only is done by calling commands via herbstclient. So the only configuration file is the `autostart` which is placed at `~/.config/herbstluftwm/` and which is a sequence of those herbstclient calls.

Open it in your favourite text editor and replace the Mod-line by this to use the Super-key (or also called Windows-key) as the main modifier:

```
# Mod=Mod1 # use alt as the main modifier
Mod=Mod4 # use Super as the main modifier
```

After saving the autostart file, you have to reload the configuration:

```
# the following line is identical to directly calling:
# ~/.config/herbstluftwm/autostart
herbstclient reload
```

Now you may notice that the red border color of your terminal turned green again, because the color is set in the default autostart. That’s the typical configuration workflow:

1.  Try some new settings in the command line
    
2.  Add them to the autostart file
    
3.  Press Mod-Shift-r which calls the `reload` command or directly execute the autostart file from your shell to get the error messages if something went wrong.
    

To learn more about herbstluftwm, just go through the man page line by line and check using the [herbstluftwm(1) man page](https://herbstluftwm.org/herbstluftwm.html) what it does. For a quick introduction to the central paradigms, continue reading this.

## Tiling

Initially there is one frame. Each frame has one of the two following possible types:

1.  It serves as a container for windows, i.e. it can hold zero up to arbitrarily many windows. Launch several more terminals to see what happens: If there are multiple windows in one frame, they are aligned below each other. To change this layout algorithm, press Mod-space to cycle all the available layouting algorithms for the focused frame.
    
2.  A frame also can be split into two subframes, which can be aligned next to or below each other. Press Mod-o to split to an horizontal alignment. To navigate to the fresh frame right of the old one press Mod-l. Press Mod-u to split vertically. The intuitive navigation is:  
    
    ```
          ⎧ h (or ←) ⎫                 ⎧ left
          ⎪ j (or ↓) ⎪   means         ⎪ down
    Mod + ⎨ k (or ↑) ⎬  ═══════> focus ⎨ up
          ⎩ l (or →) ⎭                 ⎩ right
    ```
    
    To undo splitting, you can remove a frame via Mod-r. To shift some window from one frame to one of its neighbours, use the same keyboard shortcut while holding the Shift key pressed. It is not possible to resize single windows, only to resize frames. The according keyboard shortcut is the same while holding Control pressed. All in all it is:
    
    ```
                        ⎧ h (or ←) ⎫                          ⎧ left
          ⎧         ⎫   ⎪ j (or ↓) ⎪  means  ⎧ focus frame  ⎫ ⎪ down
    Mod + ⎨ Shift   ⎬ + ⎨ k (or ↑) ⎬  ═════> ⎨ move window  ⎬ ⎨ up
          ⎩ Control ⎭   ⎩ l (or →) ⎭         ⎩ resize frame ⎭ ⎩ right
    ```
    

With this, you can define a custom layout. It can be printed via the `layout` command:

```
$ herbstclient layout
╾─┐ horizontal 50% selection=1
  ├─┐ vertical 70% selection=0
  │ ├─╼ vertical: 0x1400009
  │ └─╼ vertical:
  └─╼ max: 0x1a00009 [FOCUS]
```

Just play with it a bit to understand how it works. You also can permanently save the layout using the `dump` command:

```
$ herbstclient dump
(split horizontal:0.500000:1
    (split vertical:0.700000:0
        (clients vertical:0 0x1400009)
        (clients vertical:0))
    (clients max:0 0x1a00009))
$ layout=$(herbstclient dump)
```

And after some changes you can rewind to the original layout with the `load` command:

```
$ herbstclient load "$layout"       # mind the quotes!
```

## Tags (or workspaces or virtual desktops or ….)

A tag consists of a name and a frame layout with clients on it. With the default autostart, there are nine tags named 1 to 9. You can switch to the ith tag using Mod-i, e.g. Mod-4 to switch to tag 4 or with the command `use 4`. A window can be move to tag i via Mod-Shift-i, i.e. with the `move` command.

## Monitors

The notion of a monitor in herbstluftwm is treated much more abstract and general than in other window managers: A monitor just is a rectangular part of your screen which shows exactly one tag on it.

Initially there is only one large monitor ranging over your entire screen:

```
$ herbstclient list_monitors
0: 1440x900+0+0 with tag "1" [FOCUS]
```

The output shows that there is only one monitor with index 0 at position +0+0 of size 1440x900 showing tag 1. In most cases, the herbstluftwm monitors will match the list of physical monitors. So to add another physical monitor, you have to perform several steps:

1.  Enable it, such that it shows a part of your screen. You can use `xrandr`, `xinerama` or any other tool you like.
    
2.  Register it in herbstluftwm: Lets assume your new monitor has the resolution 1024x768 and is right of your main screen, then you can activate it via:
    
    ```
    $ herbstclient set_monitors 1440x900+0+0 1024x768+1440+0
    ```
    
    Alternatively, if `xinerama` or `xrandr` works for your setup, simply run:
    
    ```
    $ herbstclient detect_monitors
    ```
    

For even more automation, you can enable the setting `auto_detect_monitors`. For more advanced examples, look at the `q3terminal.sh` example script, which implements a drop-down-terminal like monitor where you can put any application you like.

Generated on 2022-08-23 at 13:42:10 - [Imprint and Privacy Policy](https://herbstluftwm.org/imprint.html)