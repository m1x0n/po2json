MAKEFLAGS += --silent

.PHONY: help
help:
	echo "Available commands"
	echo "make install - Installs composer dependencies"
	echo "make clean - Cleanups bin/ folder"
	echo "make compile - Builds bin/po2json using box.json"
	echo "make docker - Prepares Dockerfile for po2json"

.PHONY: install
install:
	composer install

.PHONY: clean
clean:
	rm -f ./bin/po2json

.PHONY: compile
compile:
	./vendor/bin/box compile

.PHONY: docker
docker:
	./vendor/bin/box docker
