<?php
namespace Johnimedia\LinuxSampler\Client\Examples\Cli;

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
    $sampler= new LinuxSampler('192.168.178.47');
    $output->writeln('Connecting to server...');
    $sampler->connect();
    $output->writeln('Sampler channels: ' . $sampler->getChannels());
    $channelsList = $sampler->getChannelList();
    $output->writeln('List:');
    foreach ($channelsList as $channel) {
      $output->writeln(' ' . $channel);
      $channelInfos = $sampler->getChannelInfos($channel);
      $output->writeln('  Engine Name: ' . $channelInfos->engine_name);
      $output->writeln('  Volume: ' . $channelInfos->volume);
      $output->writeln('  Audio output device: ' . $channelInfos->audio_output_device);
      $output->writeln('  Audio output channels: ' . $channelInfos->audio_output_channels);
      $output->writeln('  Audio output routing: ' . $channelInfos->audio_output_routing);
      $output->writeln('  Midi input device: ' . $channelInfos->midi_input_device);
      $output->writeln('  Midi input port: ' . $channelInfos->midi_input_port);
      $output->writeln('  Midi input channel: ' . $channelInfos->midi_input_channel);
      $output->writeln('  Instrument file: ' . $channelInfos->instrument_file);
      $output->writeln('  Instrument nr: ' . $channelInfos->instrument_nr);
      $output->writeln('  Instrument name: ' . $channelInfos->instrument_name);
      $output->writeln('  Instrument status ' . $channelInfos->instrument_status);
      $output->writeln('  Mute: ' . $channelInfos->mute);
      $output->writeln('  Solo: ' . $channelInfos->solo);
      $output->writeln('  Midi instrument map: ' . $channelInfos->midi_instrument_map);
    }
  }
}

