<?php
namespace Johnimedia\LinuxSampler\Client\Examples;

use Johnimedia\LinuxSampler\Client\LinuxSampler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChannelsCommand extends Command {

  protected function configure()
  {
    $this->setName('example:channels');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $sampler= new LinuxSampler();
    $output->writeln('Connecting to server...');
    $sampler->connect();
    $output->writeln('Sampler channels: ' . $sampler->getChannels());
    $channelsList = $sampler->getChannelList();
    $output->writeln('List:');
    foreach ($channelsList as $channel) {
      $output->writeln(' ' . $channel);
    }
  }
}

