vendor: composer.json composer.lock
	docker compose run composer install --profile --ansi

.PHONY: test
test:
	docker compose run php -d xdebug.mode=coverage vendor/bin/pest \
		--log-junit=build/junit.xml \
		--coverage-xml=build/coverage-xml

.PHONY: infect
infect:
	docker compose run php vendor/bin/infection -v \
	--coverage=build \
	--show-mutations

.PHONY: pest-2.31
pest-2.31:
	docker compose run composer require --dev pestphp/pest:2.31 --update-with-dependencies

.PHONY: pest-2.32
pest-2.32:
	docker compose run composer require --dev pestphp/pest:2.32.0 --update-with-dependencies

.PHONY: pest-latest
pest-latest:
	docker compose run composer require --dev pestphp/pest:^2 --update-with-dependencies
