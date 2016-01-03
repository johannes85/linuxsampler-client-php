<?php
namespace Johnimedia\LinuxSampler\Client\Examples;

use Johnimedia\LinuxSampler\Client\LinuxSampler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MidiDataCommand extends Command {

  protected function configure()
  {
    $this->setName('example:midiData');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $sampler= new LinuxSampler();
    $output->writeln('Connecting to server...');
    $sampler->connect();
    $output->writeln('Sending MIDI NOTE_ON...');
    $sampler->sendChannelMidiData(LinuxSampler::MIDI_MESSAGE_NOTE_ON, 0, 56, 112);
    $output->writeln('Waiting 2 seconds...');
    sleep(2);
    $output->writeln('Sending MIDI NOTE_OFF...');
    $sampler->sendChannelMidiData(LinuxSampler::MIDI_MESSAGE_NOTE_OFF, 0, 56, 112);
  }
}

