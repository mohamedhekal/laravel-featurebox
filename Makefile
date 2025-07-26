.PHONY: help install test test-coverage format check-style fix-style clean build release

help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  %-15s %s\n", $$1, $$2}' $(MAKEFILE_LIST)

install: ## Install dependencies
	composer install

test: ## Run tests
	composer test

test-coverage: ## Run tests with coverage
	composer test-coverage

format: ## Format code
	composer format

check-style: ## Check code style
	composer exec -- pint --test

fix-style: ## Fix code style
	composer exec -- pint

clean: ## Clean build artifacts
	rm -rf build/
	rm -rf dist/
	rm -rf coverage/
	rm -f *.zip
	rm -f *.tar.gz

build: ## Build package for distribution
	composer install --no-dev --optimize-autoloader
	zip -r laravel-featurebox.zip . -x "*.git*" "tests/*" ".github/*" "*.md" "Makefile" "phpunit.xml" ".gitignore" ".editorconfig" ".gitattributes"

release: ## Create a new release (requires VERSION variable)
	@if [ -z "$(VERSION)" ]; then echo "Please specify VERSION=1.0.0"; exit 1; fi
	git tag -a v$(VERSION) -m "Release v$(VERSION)"
	git push origin v$(VERSION)

setup: ## Setup development environment
	composer install
	cp config/featurebox.php.example config/featurebox.php 2>/dev/null || true

ci: ## Run CI checks
	composer test
	composer exec -- pint --test 