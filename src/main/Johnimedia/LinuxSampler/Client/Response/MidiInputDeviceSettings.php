<?php
namespace Johnimedia\LinuxSampler\Client\Response;

use Johnimedia\LinuxSampler\Client\Response;

class MidiInputDeviceSettings extends AbstractProperties
{

  /** @var string */
  public $driver;

  /** @var boolean */
  public $active;

  protected $singleProperties = ['driver' => true];
  protected $booleanProperties = ['active' => true];
}