<?php

namespace iTymz\JMeterTests\Command;

use Psr\Log\LoggerInterface;
use iTymz\JMeterTests\Helper\JMeterService;
use iTymz\JMeterTests\Model\SiteMapDownloader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SiteMapTest
 *
 * @package iTymz\JMeterTests\Command
 */
class SiteMapTest extends Command
{
    /**
     * @var array
     */
    private $siteMaps;

    /**
     * @var SiteMapDownloader
     */
    private $siteMapDownloader;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var JMeterService
     */
    private $JMeterService;

    /**
     * SiteMapTest constructor.
     *
     * @param array $siteMaps
     * @param SiteMapDownloader $siteMapDownloader
     * @param LoggerInterface $logger
     * @param JMeterService $JMeterService
     * @param null $name
     */
    public function __construct(
        array $siteMaps,
        SiteMapDownloader $siteMapDownloader,
        LoggerInterface $logger,
        JMeterService $JMeterService,
        $name = null
    )
    {
        parent::__construct($name);
        $this->siteMaps = $siteMaps;
        $this->siteMapDownloader = $siteMapDownloader;
        $this->logger = $logger;
        $this->JMeterService = $JMeterService;
    }

    protected function configure()
    {
        $this->setName('app:sitemap:test')
            ->setDescription('Run site map test based on URL address.')
            ->setHelp("This command allows you to start test based on latest site maps...");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Start test based on site maps in your config file");
        $siteMaps = $this->siteMapDownloader->downloadSiteMaps();
        $siteMaps->exportToCSVFile();
        $output->writeln("Download and export data completed for: " . implode(', ', array_keys($siteMaps->getData())));
        $this->JMeterService->startJMeterTest(SITEMAP_JMX_TEST_FILE);
    }
}