<?php


namespace iTymz\JMeterTests\Model;


use Psr\Log\LoggerInterface;
use vipnytt\SitemapParser;
use vipnytt\SitemapParser\Exceptions\SitemapParserException;

/**
 * Class SiteMapDownloader
 *
 * @package iTymz\JMeterTests\Model
 */
class SiteMapDownloader
{
    /**
     * @var array
     */
    private $data = array();

    /**
     * @var FileExporter
     */
    private $fileExporter;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SiteMapDownloader constructor.
     *
     * @param array $siteMaps
     * @param FileExporter $fileExporter
     * @param LoggerInterface $logger
     */
    public function __construct(
        array $siteMaps,
        FileExporter $fileExporter,
        LoggerInterface $logger
    )
    {
        $this->siteMaps = $siteMaps;
        $this->fileExporter = $fileExporter;
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return $this
     */
    public function downloadSiteMaps()
    {
        foreach ($this->siteMaps as $site => $url) {
            try {
                $parser = new SitemapParser();
                $parser->parse($url);
                foreach ($parser->getURLs() as $url => $tags) {
                    $this->data[$site][] = $tags;
                }
            } catch (SitemapParserException $e) {
                $this->logger->error($e);
            }
        }

        return $this;
    }

    /**
     * @param $key
     * @return $this
     */
    public function downloadSiteMapByKey($key)
    {
        try {
            $parser = new SitemapParser();
            $parser->parseRecursive($this->siteMaps[$key]);
            foreach ($parser->getURLs() as $url => $tags) {
                $this->data[$key][] = $tags;
            }
        } catch (SitemapParserException $e) {
            $this->logger->error($e);
        }

        return $this;
    }

    /**
     * Exporting site maps from context
     */
    public function exportToCSVFile()
    {
        $this->fileExporter->exportDataToCsv($this->data);
    }
}