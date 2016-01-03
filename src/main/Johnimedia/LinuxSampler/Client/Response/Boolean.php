<?php
namespace Johnimedia\LinuxSampler\Client\Response;

use Johnimedia\LinuxSampler\Client\Response;

class Boolean extends Response
{

  /** @var bool */
  public $value;

  protected function parseData(array $data)
  {
    $this->value = substr($data[0], 0, 2) == 'OK';
  }
}