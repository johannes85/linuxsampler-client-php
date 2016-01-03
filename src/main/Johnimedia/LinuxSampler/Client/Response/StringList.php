<?php
namespace Johnimedia\LinuxSampler\Client\Response;

use Johnimedia\LinuxSampler\Client\Response;

class StringList extends Response
{

  /** @var string[] */
  public $items;

  protected function parseData(array $data)
  {
    $this->items = $this->stringToList($data[0]);
  }

  /**
   * Converts comma separated list string to array
   *
   * @param $str
   * @return string[]
   */
  private function stringToList($str) {
    $list = explode(',', $str);
    if (count($list) == 1 && $list[0] == '') {
      $list = [];
    }
    return $list;
  }
}