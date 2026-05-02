.PHONY: ci audit cs stan

ci: audit cs stan

audit:
	composer audit

cs:
	vendor/bin/php-cs-fixer fix -v

stan:
	vendor/bin/phpstan analyse src --level=max
