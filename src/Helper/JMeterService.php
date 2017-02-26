<?php


namespace iTymz\JMeterTests\Helper;
use Psr\Log\LoggerInterface;


/**
 * Class JMeterService
 *
 * @package iTymz\PiTest\Helper
 */
class JMeterService
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * JMeterService constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Start test in NOT GUI mode based on your JMX file
     *
     * @param $jmxFile
     */
    public function startJMeterTest($jmxFile)
    {
        $this->logger->notice(sprintf('Start tests based on: %s', $jmxFile));
        $output = shell_exec(JMETER_BIN . ' -n -t' . $jmxFile . ' 2>&1 > ' . JMETER_OUTPUT_FILE);
        if ($output) {
            $this->logger->critical($output);
        }
    }
}