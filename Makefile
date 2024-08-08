vendor: composer.json composer.lock
	docker compose run composer install --profile --ansi

.PHONY: deptrac-public
deptrac-public:
	docker compose run php vendor/bin/deptrac --config-file deptrac-public.yaml

.PHONY: deptrac-private
deptrac-private:
	docker compose run php vendor/bin/deptrac --config-file deptrac-private.yaml
