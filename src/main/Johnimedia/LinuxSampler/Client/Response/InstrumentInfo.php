<?php
namespace Johnimedia\LinuxSampler\Client\Response;

use Johnimedia\LinuxSampler\Client\Response;

class InstrumentInfo extends AbstractProperties
{

  /** @var string */
  public $name;

  public $format_family;

  public $format_version;

  public $product;

  public $artists;

  public $key_bindings;

  public $keyswitch_bindings;

  protected $singleProperties = [
    'name' => true,
    'format_family' => true,
    'format_version' => true,
    'product' => true,
    'artists' => true,
    'key_bindings' => true,
    'keyswitch_bindings' => true
  ];
}