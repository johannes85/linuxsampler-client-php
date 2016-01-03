<?php
namespace Johnimedia\LinuxSampler\Client\Test;

use Johnimedia\LinuxSampler\Client\LinuxSampler;

class ConnectTest extends \PHPUnit_Framework_TestCase
{

  /** @var LinuxSampler */
  private $linuxsampler;

  public function setUp()
  {
    $this->linuxsampler = new LinuxSampler();
  }

  public function testConnect()
  {
    $this->linuxsampler->connect();
  }

}
