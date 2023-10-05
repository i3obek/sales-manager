**## DOCKER ##**
****
*## SHORTCUT START ##*

#
***!! ## !! TAKE CARE OF `.env` !! ## !!***
#

`cd .tools`

`./install.sh` (*first run*)

`./docker-stop.sh`

****
*## OPTIONALLY ##*

`chmod +x install.sh` / `chmod +x docker.sh`
****
*## RUN ##*

`./docker-start.sh`

`./docker-stop.sh`
****
#
**## ↓↓↓ MANUAL ↓↓↓ ##**

#
**## Run on Docker**

This option requires **Docker**, **Git** and **WSL-2** (Windows) to be installed.

**## Set Docker data**

`.tools/docker/.env`  

[//]: # (* Obecnie docker używa głównego `.env` projektu)

[//]: # (`.env`  )
`COMPOSE_PROJECT_NAME=project_name`

**## Change the database configuration in root directory**

Rename `.env.example` to `.env` and replace database credentials
<br>by default, set to given above `COMPOSE_PROJECT_NAME` value

    DB_DATABASE=project_name  
    DB_USER=project_name  
    DB_PASS=project_name

#
**## Installation of entire environment in following steps:**
- install latest version of [Git x64](https://git-scm.com/download/win/) with `Use Git and optional Unix tools from Windows Command Prompt` selected,
- run command (!as admin!) in PowerShell:
`git config --global http.sslVerify false`
- computer restart,
- install latest version of [Docker for Windows](https://www.docker.com/products/docker#/windows),
- install Ubuntu 18.04 (or newer) for Windows https://www.microsoft.com/store/productId/9N6SVWS3RX71

Run `PowerShell` with administrator privileges

- Display a list of available distributions and versions
- `wsl.exe -l -v`
- Replace the distro we need with version `2`
- `wsl.exe --set-version <distribution name> <versionNumber>`
#
**## Useful links:**

    https://docs.docker.com/docker-for-windows/wsl/

    https://code.visualstudio.com/docs/remote/wsl

    https://docs.microsoft.com/pl-pl/windows/wsl/install-win10#step-4---download-the-linux-kernel-update-package
#
**## Docker configuration setting:**

- `Settings` -> `General` -> `Send usage statistics` - uncheck the option to send statistics

- `Settings` -> `General` -> `Use the WSL 2 based engine` - check it

- `Settings` -> `Resources`-> `WSL Integration` -> select the available Distro, previously installed one
#

**## Download the project using git to a virtual disk in Ubuntu and also there operate using VSC tool.**

After installing above-mentioned programs, whole environment is **FIRST TIME** initialized with the file in Ubuntu `./install.sh` **in the `.tools` directory**

The environment is launched by file in ubuntu `./docker-start.sh` from the **.tools** directory

If it is not possible to run with this file, execute the command `chmod +x install.sh` / `chmod +x docker.sh` in the **.tools** dir

Stop docker `./docker-stop.sh` from **.tools** dir

**## Basic Docker commands**


- `docker compose up -d` - initialize the containers and run in the background,

- `docker compose start` - start containers (only stopped),

- `docker compose stop` - stop containers,

- `docker compose logs -f --tail 100` - continuous view of container logs.

- `docker compose logs -f --tail 50 php` - continuous preview of logs from the `php` service (available services: `database`,
 `php`, `nginx`).
