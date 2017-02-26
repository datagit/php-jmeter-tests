<?php

namespace iTymz\JMeterTests\Command;

use iTymz\JMeterTests\Model\SiteMapDownloader as SiteMapDownloaderModel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SiteMapDownloader
 *
 * @package iTymz\JMeterTests\Command
 */
class SiteMapDownloader extends Command
{
    /**
     * Argument of website tag from your sites.php file
     */
    const ARG_WEBSITE = "website";

    /**
     * @var array
     */
    private $siteMaps;

    /**
     * @var SiteMapDownloaderModel
     */
    private $siteMapDownloader;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SiteMapDownloader constructor.
     *
     * @param array $siteMaps
     * @param SiteMapDownloaderModel $siteMapDownloader
     * @param LoggerInterface $logger
     * @param null $name
     */
    public function __construct(
        array $siteMaps,
        SiteMapDownloaderModel $siteMapDownloader,
        LoggerInterface $logger,
        $name = null
    )
    {
        parent::__construct($name);
        $this->siteMaps = $siteMaps;
        $this->siteMapDownloader = $siteMapDownloader;
        $this->logger = $logger;
    }

    protected function configure()
    {
        $this->setName('app:sitemap:update')
            ->setDescription('Download the latest version of site map from config data.')
            ->setHelp("This command allows you to download the latest site map.");
        $this->addArgument(self::ARG_WEBSITE, InputArgument::OPTIONAL, 'The website key to download the latest site map.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!empty($siteMap = $input->getArgument(self::ARG_WEBSITE))) {
            if (in_array($siteMap, array_keys($this->siteMaps))) {
                if (isset($this->siteMaps[$siteMap])) {
                    $siteMaps = $this->siteMapDownloader->downloadSiteMapByKey($siteMap);
                    $siteMaps->exportToCSVFile();
                    $output->writeln(sprintf('Download and export data completed for: %s',
                        implode(', ', array_keys($siteMaps->getData()))
                    ));
                }
            } else {
                $output->writeln("Site map " . $siteMap . " does not exists in your config file!!!");
            }
        } else {
            $output->writeln("Start download site maps contained in your config file");
            $siteMaps = $this->siteMapDownloader->downloadSiteMaps();
            $siteMaps->exportToCSVFile();
            $output->writeln(sprintf('Download and export data completed for: %s',
                implode(', ', array_keys($siteMaps->getData()))
            ));
        }
    }
}