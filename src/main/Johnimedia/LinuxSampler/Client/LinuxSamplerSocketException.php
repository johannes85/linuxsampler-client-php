<?php
namespace Johnimedia\LinuxSampler\Client;

class LinuxSamplerSocketException extends LinuxSamplerException
{
  public function __construct($message, $socketErrorNo, $socketErrorMessage) {
    parent::__construct(sprintf(
      '%s Socket error [%s] (%s)',
      $message,
      $socketErrorNo,
      $socketErrorMessage
    ));
  }
}