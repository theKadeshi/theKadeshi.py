# theKadeshi #
### Antivirus for your web-site ###
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/fd626f73d9c746bc960b1b085c163473)](https://www.codacy.com/app/ntorgov/theKadeshi.py?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ntorgov/theKadeshi.py&amp;utm_campaign=Badge_Grade)

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
* `-nc` - Disables cleanup mode. Enabled by default
* `-nr` - Disables report file. Enabled by default

#### Requirements ####
* Python 3.6+
