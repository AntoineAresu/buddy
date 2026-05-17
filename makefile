.PHONY: ci audit cs stan

PHPUNIT       = $(BIN)/simple-phpunit
BIN    	      = ./vendor/bin
PHP_CS_FIXER  = $(BIN)/php-cs-fixer
PHPSTAN       = $(BIN)/phpstan
PHPUNIT       = $(PHP) $(BIN)/phpunit
PHP           = php
DOCKER_COMPOSE  = docker compose
DEPLOYER      = $(BIN)/dep

# ──────────────────────────────────────────────────────────────────────────────
# CI
# ──────────────────────────────────────────────────────────────────────────────

ci: audit cs stan tests

tests: run_tests

audit:
	composer audit

cs:
	$(PHP_CS_FIXER) fix -v

stan:
	$(PHPSTAN) analyse src --level=max

run_tests:
	@$(PHPUNIT) tests

# ──────────────────────────────────────────────────────────────────────────────
# Docker
# ──────────────────────────────────────────────────────────────────────────────

migrate:
	$(DOCKER_COMPOSE) exec php bin/console doctrine:migrations:migrate --no-interaction

build:
	$(DOCKER_COMPOSE) build --no-cache

build_pp:
	$(DOCKER_COMPOSE) -f compose.yaml -f compose.preprod.yaml build --no-cache

up:
	$(DOCKER_COMPOSE) up -d --wait

up_pp:
	$(DOCKER_COMPOSE) -f compose.yaml -f compose.preprod.yaml up -d

down:
	$(DOCKER_COMPOSE) down

down_pp:
	$(DOCKER_COMPOSE) -f compose.yaml -f compose.preprod.yaml down

sh:
	$(DOCKER_COMPOSE) exec php sh

ps:
	$(DOCKER_COMPOSE) ps

# ──────────────────────────────────────────────────────────────────────────────
# Deploy
# ──────────────────────────────────────────────────────────────────────────────

deploy_preprod:
	$(DEPLOYER) deploy buddy_pp
