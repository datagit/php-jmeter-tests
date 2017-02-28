# PHP Apache JMeter Tests

Simple PHP CLI app that allows to perform crawler (with tests) based on latest site map, and run your personal functional tests.

### Questions
If you have any questions, problems related with this project send me an email, or catch me on twitter [@_iTymz](https://twitter.com/_iTymz).

### Prerequisites

* PHP >=7.0
* Composer
* Apache JMeter >=3.1

**Optional (for statistic)**

* InfluxDB
* Grafana

** More information:
http://www.testautomationguru.com/jmeter-real-time-results-influxdb-grafana/

### Installing
As first:
```
composer install
```

Then create your configuration files, sample versions can be found in `conf` directory, and next

```
php cli/app
```

In `Available commands` section you should see

```  
 Lists commands
 app
  app:functional:test       Run functional test.
  app:sitemap:test          Run site map test based on latest site maps.
  app:sitemap:update        Download the latest version of site map from config data.

```

## Example Apache JMeter tests
Based structure of a simple site map test in `examples` directory.

## Running site map tests

Downloads the latest site map of the pages contained in the configuration file `sites.php`
and run the test based on your JMX file.

`php cli/app app:sitemap:test`

## Running functional tests

`php cli/app app:functional:test`

## License

MIT License - see the [LICENSE.md](LICENSE.md) file for details