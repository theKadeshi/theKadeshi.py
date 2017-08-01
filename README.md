# theKadeshi #
### Antivirus for your web-site ###
[![Code Issues](https://www.quantifiedcode.com/api/v1/project/40bbe4ed3bdf46af9107edcea02e9d22/badge.svg)](https://www.quantifiedcode.com/app/project/40bbe4ed3bdf46af9107edcea02e9d22)

[TOC]

#### Usage ####
Download latest version from release section: [Releases](https://github.com/theKadeshi/theKadeshi.py/releases)

Unpack the .zip file.

#### Options ####
Source code startup:
```shell
python kadeshi.py [options] /home/name/your_site_folder/
```
Windows binaries:
```powershell
kadeshi.exe [options] c:\temp\sites\your_site_folder\
```
Options are:

* `-h`  - Help
* `-v`  - Version
* `-bw` - Disables color output. Enabled by default. Try this option if you see something like this: `...php (?[32mClean?[39m)...`
* `-nh` - Disables heuristic detection. Enabled by default
* `-nc` - Disables cleanup mode. Enabled by default
* `-nr` - Disables report file. Enabled by default

#### Requirements ####
* Python 3.6+
