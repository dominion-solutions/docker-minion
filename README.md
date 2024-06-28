# A package to integrate Laravel with the Docker daemon

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dominion-solutions/docker-minion.svg?style=flat-square)](https://packagist.org/packages/dominion-solutions/docker-minion)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/dominion-solutions/docker-minion/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/dominion-solutions/docker-minion/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/dominion-solutions/docker-minion/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/dominion-solutions/docker-minion/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/dominion-solutions/docker-minion.svg?style=flat-square)](https://packagist.org/packages/dominion-solutions/docker-minion)

## Features
### Monitoring
Monitors the docker socket in order to be able to provide data about what containers are running.

### Control
Allows starting / stopping / restarting of containers.

## Support us

<!-- [<img src="https://github-ads.s3.eu-central-1.amazonaws.com/docker-minion.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/docker-minion) -->

We invest a lot of resources into creating [best in class open source packages](https://dominion.solutions/open-source?utm_source=docker_minion&utm_medium=readme&utm_campaign=open_source&utm_content=textlink). You can support us by [hiring us or buying one of our paid products](https://dominion.solutions/products?utm_source=docker_minion&utm_medium=readme&utm_campaign=open_source&utm_content=textlink).

## Installation

You can install the package via composer:

```bash
composer require dominion-solutions/docker-minion
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="docker-minion-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="docker-minion-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="docker-minion-views"
```

## Usage

```php
$dockerMinion = new DominionSolutions\DockerMinion();
echo $dockerMinion->echoPhrase('Hello, DominionSolutions!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mark J. Horninger](https://github.com/dominion-solutions)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
