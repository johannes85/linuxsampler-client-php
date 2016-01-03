<?php
namespace Johnimedia\LinuxSampler\Client\Response;

use Johnimedia\LinuxSampler\Client\Response;

abstract class AbstractProperties extends Response
{
  protected $singleProperties = [];

  protected $multiProperties = [];

  protected $booleanProperties = [];

  protected function parseData(array $data)
  {
    foreach ($data as $line) {
      if (preg_match('/([A-Z]+):\s*(.*)/', $line, $m)) {
        $field = strtolower($m[1]);
        if (isset($this->singleProperties[$field])) {
          $this->$field = $m[2];
        } elseif (isset($this->multiProperties[$field])) {
          $this->$field = explode(',', $m[2]);
        } elseif (isset($this->booleanProperties[$field])) {
          $this->$field = $m[2] == 'true';
        }
      }
    }
  }
}