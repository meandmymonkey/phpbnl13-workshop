<?php

namespace Acme\Bundle\DicWorkshopBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Acme\Bundle\DicWorkshopBundle\Ecb\ExchangeRates;

class ExchangeRatesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ecb:exchangerates')
            ->setDefinition(array(
                new InputArgument('currency', InputArgument::OPTIONAL, 'A currency code ')
            ))
            ->setDescription('Outputs current Euro exchange rates')
            ->setHelp('Outputs current Euro exchange rates')
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ExchangeRates $ecb */
        $ecb = $this->getContainer()->get('acme.rates');
        $selectedCurrency = $input->getArgument('currency');

        if (null === $selectedCurrency) {
            foreach ($ecb->getRates() as $currency => $rate) {
                $this->printRate($output, $currency, $rate);
            }
        } else {
            $this->printRate($output, $input->getArgument('currency'), $ecb->getRate($selectedCurrency));
        }
    }

    protected function printRate(OutputInterface $output, $currency, $rate)
    {
        $output->writeln(sprintf('<info>%s</info> %s', $currency, $rate));
    }
}
