<?php
namespace Johnimedia\LinuxSampler\Client\Response;

use Johnimedia\LinuxSampler\Client\Response;

class Integer extends Response
{

  /** @var int */
  public $value;

  protected function parseData(array $data)
  {
    $this->value = (int)$data[0];
  }
}