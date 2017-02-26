<?php

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use iTymz\JMeterTests\Command\SiteFunctionalTest;
use iTymz\JMeterTests\Command\SiteMapDownloader;
use iTymz\JMeterTests\Command\SiteMapTest;
use iTymz\JMeterTests\Model\SiteMapDownloader as SiteMapDownloaderModel;


require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../conf/app.php';
$siteMap = require_once __DIR__ . '/../conf/sites.php';

if (!is_array($siteMap)) {
    die("Please check your conf/sites.php file as it probably has the wrong structure.");
}

$builder = new DI\ContainerBuilder();
$builder->addDefinitions([
    Psr\Log\LoggerInterface::class => DI\factory(function () {
        $logger = new Logger('app');

        $fileHandler = new StreamHandler(__DIR__ . '/../var/log/app.log', Logger::DEBUG);
        $fileHandler->setFormatter(new LineFormatter());
        $logger->pushHandler($fileHandler);

        return $logger;
    }),
    SiteMapDownloaderModel::class => DI\object()
        ->constructorParameter('siteMaps', $siteMap),
    SiteFunctionalTest::class => DI\object()
        ->constructorParameter('siteMaps', $siteMap),
    SiteMapDownloader::class => DI\object()
        ->constructorParameter('siteMaps', $siteMap),
    SiteMapTest::class => DI\object()
        ->constructorParameter('siteMaps', $siteMap),
]);
$container = $builder->build();
