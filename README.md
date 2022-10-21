# Testing

## Install vendors

`docker run --rm --interactive --tty --volume $PWD:/app composer install --dev`

## Run tests

`docker run -v $(pwd):/app --rm phpunit/phpunit .`