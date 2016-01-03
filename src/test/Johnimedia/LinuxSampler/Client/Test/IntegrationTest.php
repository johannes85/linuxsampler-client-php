<?php
namespace Johnimedia\LinuxSampler\Client\Test;

use Johnimedia\LinuxSampler\Client\LinuxSampler;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{

  /** @var LinuxSampler */
  private $linuxsampler;

  public function setUp()
  {
    $this->linuxsampler = new LinuxSampler();
    $this->linuxsampler->connect();
  }

  public function testGetAvailableAudioOutputDrivers()
  {
    $res = $this->linuxsampler->getAvailableAudioOutputDrivers();
    $this->assertInternalType('int', $res);
  }

}
