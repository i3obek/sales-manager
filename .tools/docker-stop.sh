#!/bin/bash

source docker/.env
echo $COMPOSE_PROJECT_NAME

BOLD="$(tput bold)"
RED="$(tput setaf 1)"
RESET="$(tput sgr0)"

cd docker
docker compose -p ${COMPOSE_PROJECT_NAME} ps
docker compose -p ${COMPOSE_PROJECT_NAME} stop
docker compose -p ${COMPOSE_PROJECT_NAME} ps
cd ../

echo ""
echo -e "${BOLD}${RED}---------${RESET}"
echo -e "Project containers stopped${RESET}"
echo -e "${BOLD}${RED}---------${RESET}"
echo ""
read -n 1 -s -r -p "Press enter to continue..."
