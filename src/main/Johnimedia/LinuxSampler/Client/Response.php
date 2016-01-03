<?php
namespace Johnimedia\LinuxSampler\Client;

abstract class Response
{

  public $errorNo = null;
  public $errorMessage = null;
  public $isError = false;
  public $isWarning = false;

  protected $errorHandler;

  public function __construct($data, $errorHandler = null)
  {
    $this->errorHandler = $errorHandler;
    if (strlen($data[0]) > 2) {
      $this->isError = substr($data[0], 0, 3) == 'ERR';
      $this->isWarning = substr($data[0], 0, 3) == 'WRN';
      if ($this->isError || $this->isWarning) {
        if (preg_match('/[A-Z]{3}:(.+?):(.+)/i', $data[0], $m)) {
          $this->errorNo = $m[1];
          $this->errorMessage = $m[2];
        } else {
          $this->errorNo = 0;
          $this->errorMessage = sprintf('Unknown error (%s)', $data[0]);
        }
        if ($this->errorHandler !== null) {
          $this->errorHandler->__invoke($this->errorNo, $this->errorMessage);
        }
      } else {
        $this->parseData($data);
      }
    } else {
      $this->parseData($data);
    }
  }

  protected abstract function parseData(array $data);
}