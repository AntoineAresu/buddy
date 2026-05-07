.PHONY: ci audit cs stan

PHPUNIT       = $(BIN)/simple-phpunit
BIN    	      = ./vendor/bin
PHP_CS_FIXER  = $(BIN)/php-cs-fixer
PHPSTAN       = $(BIN)/phpstan
PHPUNIT       = $(PHP) $(BIN)/phpunit
PHP           = php


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
