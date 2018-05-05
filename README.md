# Argo
**Named after the ship on which Jason and the Argonauts sailed**

_We restructured the way we store parts and construct Gears when spawning, which should reduce the likelihood of lag spikes from multiple Gears spawning simultaneously. As a result, certain values for Gears, such as armour and internal health, can now be updated much quicker and without needing to push out a client update. As such, we have taken this opportunity to adjust some of the base values. Additionally, this change also gives our community a tool to play with allowing hosts to set custom house rules on their own servers._

This new feature allows us to change Gear stats **server side** by reading custom JSON files. We created a simplified and user-friendly **web form** to generate the necessary files. It started as simple in-house export script but I wanted to provide a tool for our community as well.

![Image of ARGO](http://houruck.hu/pix/warrior.png)

1. Pick a Gear from the list in the centre. It will load the current default values.

2. Edit the values as you desire and click ‘download’ to get a zip file. It has minified JSON files in it (condensed into a single line without whitespaces) so we transmit less data.

3. Locate your install of HGA and create the following folder structure:
`\HGGame\Saved\GameData\Gears\`

4. Create the subfolders for the Gears and unzip the corresponding files in them.

Example:
`D:\Games\Heavy Gear Assault\HGGame\Saved\GameData\Gears\Hunter`

The Hunter folder should contain:
```
SADL.json //Section Arm Down Left
SADR.json //Section Arm Down Right
SAUL.json //Section Arm Up Left
SAUR.json //Section Arm Up Right
SFL.json //Section Foot Left
SFR.json //Section Foot Right
SHED.json //Section HEaD
SHIP.json //Section HIP
SLDL.json //Section Leg Down Left
SLDR.json //Section Leg Down Right
SLUL.json //Section Leg Up Left
SLUR.json //Section Leg Up Right
SSHL.json //Section SHoulder Left
SSHR.json //Section SHoulder Right
STOR.json //Section TORso
SHR.json //Section Hand Right
SHL.json //Section Hand Left
```

Example:
`D:\Games\Heavy Gear Assault\HGGame\Saved\GameData\Gears`

We encourage our technically minded users to look into these files. To make the json files human-readable use a formatter tool or an editor plugin. If it fails it will stop at the faulty part and won’t spawn the ones following it. It reads them from top to bottom (in this order: SHED, STOR, SHIP, SSHL, SAUL, SADL, SHL, SSHR, SAUR, SADR, SHR, SLUL, SLDL, SFL, SLUR, SLDR, SFR). Switch to third person (‘C’ by default) to check it.
