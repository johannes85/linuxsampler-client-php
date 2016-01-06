<?php
namespace Johnimedia\LinuxSampler\Client\Examples\Cli;

use Johnimedia\LinuxSampler\Client\LinuxSampler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstrumentsFileCommand extends Command {

  protected function configure()
  {
    $this->setName('example:instrumentsFile');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $sampler= new LinuxSampler('192.168.178.47');
    $output->writeln('Connecting to server...');
    $sampler->connect();
    $output->writeln('Instruments in File ' . $sampler->getChannels());
    $instrumentsList = $sampler->listFileInstruments('/home/pi/linuxsampler/telecaster.gig');
    $output->writeln('List:');
    foreach ($instrumentsList as $instrument) {
      $output->writeln(' ' . $instrument);
      $instrumentInfo = $sampler->getFileInstrumentInfo('/home/pi/linuxsampler/telecaster.gig', $instrument);
      $output->writeln('  Name: ' . $instrumentInfo->name);
      $output->writeln('  Format family: ' . $instrumentInfo->format_family);
      $output->writeln('  Format version: ' . $instrumentInfo->format_version);
      $output->writeln('  Product: ' . $instrumentInfo->product);
      $output->writeln('  Artists: ' . $instrumentInfo->artists);
      $output->writeln('  Key bindings: ' . $instrumentInfo->key_bindings);
      $output->writeln('  Keyswitch bindings: ' . $instrumentInfo->keyswitch_bindings);
    }
  }
}

