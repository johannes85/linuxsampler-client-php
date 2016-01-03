<?php
namespace Johnimedia\LinuxSampler\Client\Response;

use Johnimedia\LinuxSampler\Client\Response;

abstract class AbstractDriverInfos extends AbstractProperties
{

  /** @var string */
  public $description;

  /** @var float */
  public $version;

  /** @var string[] */
  public $parameters;

  protected $singleProperties = ['description' => true, 'version' => true];
  protected $multiProperties = ['parameters' => true];
}