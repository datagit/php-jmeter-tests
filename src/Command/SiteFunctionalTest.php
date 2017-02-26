<?php

namespace iTymz\JMeterTests\Command;

use Psr\Log\LoggerInterface;
use iTymz\JMeterTests\Helper\JMeterService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SiteFunctionalTest
 *
 * @package iTymz\JMeterTests\Command
 */
class SiteFunctionalTest extends Command
{
    /**
     * @var JMeterService
     */
    private $JMeterService;

    /**
     * SiteFunctionalTest constructor.
     *
     * @param JMeterService $JMeterService
     * @param null $name
     */
    public function __construct(
        JMeterService $JMeterService,
        $name = null
    )
    {
        parent::__construct($name);
        $this->JMeterService = $JMeterService;
    }

    protected function configure()
    {
        $this->setName('app:functional:test')
            ->setDescription('Run functional test.')
            ->setHelp('This command allows you to start functional test...');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Start functional test based on JMX File');
        $this->JMeterService->startJMeterTest(FUNCTIONAL_JMX_TEST_FILE);
    }
}