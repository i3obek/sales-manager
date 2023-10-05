#!/bin/bash

echo ""
source docker/.env
echo $COMPOSE_PROJECT_NAME

BOLD="$(tput bold)"
RED="$(tput setaf 1)"
GREEN="$(tput setaf 2)"
YELLOW="$(tput setaf 3)"
BLUE="$(tput setaf 4)"
RESET="$(tput sgr0)"

cd docker
docker compose pull
docker compose -p ${COMPOSE_PROJECT_NAME} build --progress plain
sleep 3
docker compose -p ${COMPOSE_PROJECT_NAME} up -d
cd ../
echo ""
echo -e "Project config: "

echo -e "${BOLD}${RED}---------${RESET}"
echo -e "${BOLD}Wait for containers and network${RESET}"
sleep 10

#Setup internal docker network
#if ! (docker network ls | grep overlay); then
#    echo -e "${BOLD}${RED}---------${RESET}"
#    echo -e 'docker swarm init'
#    docker swarm init
#fi
#
#if ! (docker network ls | grep ${COMPOSE_NETWORK}); then
#    echo -e "${BOLD}${RED}---------${RESET}"
#    echo -e "docker network create -d overlay --attachable ${COMPOSE_NETWORK}"
#    docker network create -d overlay --attachable ${COMPOSE_NETWORK}
#fi

#echo -e "${BOLD}${RED}---------${RESET}"
#echo -e "chmod -R 0777 storage "
#docker exec -it ${COMPOSE_PROJECT_NAME}_php chmod -R 0777 storage

echo -e "${BOLD}${RED}---------${RESET}"
echo -e "Composer install"
docker exec -it ${COMPOSE_PROJECT_NAME}_php composer install

echo -e "${BOLD}${RED}---------${RESET}"
echo -e "docker exec -it ${COMPOSE_PROJECT_NAME}_php symfony check:requirements"
docker exec -it ${COMPOSE_PROJECT_NAME}_php symfony check:requirements

echo -e "${BOLD}${RED}---------${RESET}"
echo -e "php bin/console secrets:generate-keys"
docker exec -it ${COMPOSE_PROJECT_NAME}_php php bin/console secrets:generate-keys

echo -e "${BOLD}${RED}---------${RESET}"
echo -e "symfony check:security"
docker exec -it ${COMPOSE_PROJECT_NAME}_php symfony check:security

echo -e "${BOLD}${RED}---------${RESET}"
echo -e "php bin/console doctrine:database:create"
docker exec -it ${COMPOSE_PROJECT_NAME}_php php bin/console doctrine:database:create

echo -e "${BOLD}${RED}---------${RESET}"
echo -e "php bin/console doctrine:migrations:migrate"
docker exec -it ${COMPOSE_PROJECT_NAME}_php php bin/console --no-interaction doctrine:migrations:migrate

#Connect internal docker network
#echo -e "${BOLD}${RED}---------${RESET}"
#echo -e "Connect ${COMPOSE_PROJECT_NAME}_database to internal docker network ${COMPOSE_NETWORK}"
#docker network connect ${COMPOSE_NETWORK} ${COMPOSE_PROJECT_NAME}_database

echo -e "${BOLD}${RED}---------${RESET}"
echo -e "${BOLD}${RED}TESTS${RESET}"
echo -e "${BOLD}${YELLOW}TESTS${RESET}"
echo -e "${BOLD}${GREEN}TESTS${RESET}"
docker exec -it ${COMPOSE_PROJECT_NAME}_php ./bin/phpunit

echo -e "${BOLD}${RED}---------${RESET}"
echo -e "php bin/console cache:clear"
docker exec -it ${COMPOSE_PROJECT_NAME}_php php bin/console cache:clear

echo "${BOLD}${RED}--------------------------------------------------------------------------------${RESET}"
echo "${YELLOW}DB server available at: ${BOLD}${GREEN}${COMPOSE_IP}:${COMPOSE_PORT_DB}${RESET}"
echo "${YELLOW}App available at: ${BOLD}${GREEN}${COMPOSE_IP}:${COMPOSE_PORT_HTTP}${RESET}"
echo "${BOLD}${RED}--------------------------------------------------------------------------------${RESET}"
echo ""

read -n 1 -s -r -p "Press enter to continue..."
