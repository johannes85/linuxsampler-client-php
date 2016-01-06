<?php
namespace Johnimedia\LinuxSampler\Client\Response;

use Johnimedia\LinuxSampler\Client\Response;

class ChannelInfos extends AbstractProperties
{

  /** @var string */
  public $engine_name;

  /** @var float */
  public $volume;

  /** @var int */
  public $audio_output_device;

  /** @var int */
  public $audio_output_channels;

  /** @var string */
  public $audio_output_routing;

  /** @var int */
  public $midi_input_device;

  /** @var int */
  public $midi_input_port;

  /** @var string */
  public $midi_input_channel;

  /** @var string */
  public $instrument_file;

  /** @var int */
  public $instrument_nr;

  /** @var string */
  public $instrument_name;

  /** @var int */
  public $instrument_status;

  /** @var string */
  public $midi_instrument_map;

  /** @var boolean */
  public $mute;

  /** @var boolean */
  public $solo;

  protected $singleProperties = [
    'engine_name' => true,
    'volume' => true,
    'audio_output_device' => true,
    'audio_output_channels' => true,
    'audio_output_routing' => true,
    'midi_input_device' => true,
    'midi_input_port' => true,
    'midi_input_channel' => true,
    'instrument_file' => true,
    'instrument_nr' => true,
    'instrument_name' => true,
    'instrument_status' => true,
    'midi_instrument_map' => true
  ];

  protected $booleanProperties = [
    'mute' => true,
    'solo' => true
  ];
}