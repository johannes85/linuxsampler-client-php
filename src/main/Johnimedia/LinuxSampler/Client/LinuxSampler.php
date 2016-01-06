<?php
namespace Johnimedia\LinuxSampler\Client;

use Johnimedia\LinuxSampler\Client\Response\AudioOutputDriver;
use Johnimedia\LinuxSampler\Client\Response\Boolean;
use Johnimedia\LinuxSampler\Client\Response\ChannelInfos;
use Johnimedia\LinuxSampler\Client\Response\InstrumentInfo;
use Johnimedia\LinuxSampler\Client\Response\Integer;
use Johnimedia\LinuxSampler\Client\Response\MidiInputDeviceSettings;
use Johnimedia\LinuxSampler\Client\Response\MidiInputDriver;
use Johnimedia\LinuxSampler\Client\Response\StringList;

class LinuxSampler
{

  const MIDI_MESSAGE_NOTE_ON = 'NOTE_ON';
  const MIDI_MESSAGE_NOTE_OFF = 'NOTE_OFF';
  const MIDI_MESSAGE_CC = 'CC';

  /** @var string */
  private $host;

  /** @var int */
  private $port;

  private $socket = null;

  public function __construct($host = 'localhost', $port = 8888)
  {
    $this->host = $host;
    $this->port = $port;
  }

  public function __destruct()
  {
    $this->disconnect();
  }

  public function connect()
  {
    $this->socket = @fsockopen($this->host, $this->port, $errorNo, $errorMessage);
    if (!$this->socket) {
      throw new LinuxSamplerSocketException(
        sprintf(
          'Could not connect to %s:%s',
          $this->host,
          $this->port
        ),
        $errorNo,
        $errorMessage
      );
    }
  }

  public function disconnect()
  {
    if ($this->isConnected()) {
      fclose($this->socket);
    }
  }

  /**
   * Returns true if socket is connected
   *
   * @return bool
   */
  private function isConnected() {
    return $this->socket != null;
  }

  /**
   * Escapes string for sending it to the api
   *
   * @param $string
   * @return string
   */
  private function escape($string) {
    return $string;
  }

  /**
   * Sends command to server
   *
   * @param string $command
   * @return Response
   * @throws LinuxSamplerException
   */
  private function send($command, $expectMultilineResult = false) {
    if (!$this->isConnected()) {
      throw new LinuxSamplerException('Connection isn\'t opened');
    }
    $command .= "\n";
    fwrite($this->socket, $command);
    $buffer = [];
    $currentLine = '';
    $finished = false;
    do {
      $answer = fgets($this->socket, 1024);
      if (($nlPos = strpos($answer, "\r\n")) !== false) {
        $currentLine.= substr($answer, 0, $nlPos);
        if (
          strlen($currentLine) > 2 &&
          (
            substr($currentLine, 0, 3) == 'ERR' ||
            substr($currentLine, 0, 3) == 'WRN'
          )
        ) {
          $finished = true;
          $buffer[] = $currentLine;
        } elseif ($currentLine != '.') {
          $buffer[] = $currentLine;
        } else {
          $finished = true;
        }
        if (!$expectMultilineResult) {
          $finished = true;
        }
        $currentLine = '';
      } else {
        $currentLine .= $answer;
      }
    } while ($finished == false);
    return ($buffer);
  }

  /**
   * Getting amount of available audio output drivers
   *
   * @return int
   * @throws LinuxSamplerException
   */
  public function getAvailableAudioOutputDrivers() {
    $res = $this->send('GET AVAILABLE_AUDIO_OUTPUT_DRIVERS', false);
    return (new Integer($res))->value;
  }

  /**
   * Getting all available audio output drivers
   *
   * @return string[]
   * @throws LinuxSamplerException
   */
  public function getAvailableAudioOutputDriverList() {
    $res = $this->send('LIST AVAILABLE_AUDIO_OUTPUT_DRIVERS', false);
    return (new StringList($res))->items;
  }

  /**
   * Getting information about a specific audio output driver
   *
   * @return AudioOutputDriver
   * @throws LinuxSamplerException
   */
  public function getAudioOutputDriverInfo($driver) {
    $res = $this->send('GET AUDIO_OUTPUT_DRIVER INFO ' . $driver, true);
    return new AudioOutputDriver($res, function ($no, $message) use ($driver) {
      throw new LinuxSamplerException(sprintf(
        'Could not get audio output driver infos for %s (%s)',
        $driver,
        $message
      ));
    });
  }

  /**
   * Getting information about a specific audio output driver
   *
   * @return int
   * @throws LinuxSamplerException
   */
  public function getAvailableMidiInputDrivers() {
    $res = $this->send('GET AVAILABLE_MIDI_INPUT_DRIVERS', false);
    return (new Integer($res))->value;
  }


  /**
   * Getting all available MIDI input drivers
   *
   * @return string[]
   * @throws LinuxSamplerException
   */
  public function getAvailableMidiInputDriverList() {
    $res = $this->send('LIST AVAILABLE_MIDI_INPUT_DRIVERS', false);
    return (new StringList($res))->items;
  }

  /**
   * Getting information about a specific audio output driver
   *
   * @return MidiInputDriver
   * @throws LinuxSamplerException
   */
  public function getMidiInputDriverInfo($driver) {
    $res = $this->send('GET MIDI_INPUT_DRIVER INFO ' . $driver, true);
    return new MidiInputDriver($res, function ($no, $message) use ($driver) {
      throw new LinuxSamplerException(sprintf(
        'Could not get midi input driver infos for %s (%s)',
        $driver,
        $message
      ));
    });
  }

  /**
   * @param string $midiInputDriver
   * @return bool
   * @throws LinuxSamplerException
   */
  public function createMidiInputDevice($midiInputDriver) {
    $res = $this->send('CREATE MIDI_INPUT_DEVICE ' . $midiInputDriver, false);
    return (new Boolean($res, function ($no, $message) use ($midiInputDriver) {
      throw new LinuxSamplerException(sprintf(
        'Could not create midi input device for driver %s (%s)',
        $midiInputDriver,
        $message
      ));
    }))->value;
  }

  /**
   * Destroying a MIDI input device
   *
   * @param int $deviceId
   * @return bool
   * @throws LinuxSamplerException
   */
  public function destroyMidiInputDevice($deviceId) {
    $res = $this->send('DESTROY MIDI_INPUT_DEVICE ' . $deviceId, false);
    return (new Boolean($res, function ($no, $message) use ($deviceId) {
      throw new LinuxSamplerException(sprintf(
        'Could not destroy midi input device %s (%s)',
        $deviceId,
        $message
      ));
    }))->value;
  }

  /**
   * Getting all created MIDI input device count
   *
   * @return int
   * @throws LinuxSamplerException
   */
  public function getMidiInputDevices() {
    $res = $this->send('GET MIDI_INPUT_DEVICES', false);
    return (new Integer($res))->value;
  }

  /**
   * Getting all created MIDI input device list
   *
   * @return string[]
   * @throws LinuxSamplerException
   */
  public function getMidiInputDeviceList() {
    $res = $this->send('LIST MIDI_INPUT_DEVICES', false);
    return (new StringList($res, function ($no, $message) {
      throw new LinuxSamplerException(sprintf(
        'Could not get list of MIDI input devices (%s)',
        $message
      ));
    }))->items;
  }

  /**
   * Getting current settings of a MIDI input device
   *
   * @param int $deviceId
   * @return MidiInputDeviceSettings
   * @throws LinuxSamplerException
   */
  public function getMidiInputDeviceSettings($deviceId) {
    $res = $this->send('GET MIDI_INPUT_DEVICE INFO ' . $deviceId, true);
    return new MidiInputDeviceSettings($res);
  }

  /**
   * Changing settings of MIDI input devices
   *
   * @param int $deviceId
   * @param string $key
   * @param string $value
   * @return bool
   * @throws LinuxSamplerException
   */
  public function setMidiInputDeviceParameter($deviceId, $key, $value) {
    $res = $this->send(sprintf(
      'SET MIDI_INPUT_DEVICE_PARAMETER %s %s=$s',
      $deviceId,
      $key,
      $value
    ), false);
    return (new Boolean($res))->value;
  }

  /**
   * Loading an instrument
   *
   * @param string $filename
   * @param int $instrumentId
   * @param int $samplerChannelId
   * @param bool $modal
   * @return bool
   * @throws LinuxSamplerException
   */
  public function loadInstrument($filename, $instrumentId, $samplerChannelId, $modal = true) {
    $res = $this->send(sprintf(
      'LOAD INSTRUMENT %s\'%s\' %s %s',
      $modal ? '' : 'NON_MODAL ',
      $this->escape($filename),
      $instrumentId,
      $samplerChannelId
    ), false);
    return (new Boolean($res, function ($no, $message) use ($instrumentId, $filename) {
      throw new LinuxSamplerException(sprintf(
        'Could not load instrument %s from file %s (%s)',
        $instrumentId,
        $filename,
        $message
      ));
    }))->value;
  }

  /**
   * Loading a sampler engine
   *
   * @param string $name
   * @param int $samplerChannelId
   * @return bool
   * @throws LinuxSamplerException
   */
  public function loadEngine($name, $samplerChannelId) {
    $res = $this->send(sprintf(
      'LOAD ENGINE %s %s',
      $name,
      $samplerChannelId
    ), false);
    return (new Boolean($res, function ($no, $message) use ($name) {
      throw new LinuxSamplerException(sprintf(
        'Could not load sampler engine %s (%s)',
        $name,
        $message
      ));
    }))->value;
  }

  /**
   * Getting all created sampler channel count
   *
   * @return int
   * @throws LinuxSamplerException
   */
  public function getChannels() {
    $res = $this->send('GET CHANNELS', false);
    return (new Integer($res))->value;
  }

  /**
   * Getting all created sampler channel list
   *
   * @return string[]
   * @throws LinuxSamplerException
   */
  public function getChannelList() {
    $res = $this->send('LIST CHANNELS', false);
    return (new StringList($res))->items;
  }

  /**
   * Getting sampler channel information
   *
   * @param int $samplerChannelId
   * @return ChannelInfos
   * @throws LinuxSamplerException
   */
  public function getChannelInfos($samplerChannelId) {
    $res = $this->send('GET CHANNEL INFO ' . $samplerChannelId, true);
    return new ChannelInfos($res);
  }

  /**
   * Sending MIDI messages to sampler channel
   *
   * @param string $midiMsg
   * @param int $samplerChannelId
   * @param $arg1
   * @param $arg2
   * @return bool
   * @throws LinuxSamplerException
   */
  public function sendChannelMidiData($midiMsg, $samplerChannelId, $arg1, $arg2) {
    $res = $this->send(sprintf(
      'SEND CHANNEL MIDI_DATA %s %s %s %s',
      $midiMsg,
      $samplerChannelId,
      $arg1,
      $arg2
    ), false);
    return (new Boolean($res, function ($no, $message) use ($midiMsg, $samplerChannelId) {
      throw new LinuxSamplerException(sprintf(
        'Could not send midi message %s to sampler channel %s (%s)',
        $midiMsg,
        $samplerChannelId,
        $message
      ));
    }))->value;
  }

  /**
   * Retrieving all instruments of a file
   *
   * @param string $filename
   * @return int[]
   * @throws LinuxSamplerException
   */
  public function listFileInstruments($filename) {
    $res = $this->send('LIST FILE INSTRUMENTS \'' . $this->escape($filename) . '\'', false);
    return (new StringList($res))->items;
  }

  /**
   * Retrieving informations about one instrument in a file
   *
   * @param string $filename
   * @param int $instrumentId
   * @return InstrumentInfo
   * @throws LinuxSamplerException
   */
  public function getFileInstrumentInfo($filename, $instrumentId) {
    $res = $this->send(sprintf(
      'GET FILE INSTRUMENT INFO \'%s\' %s',
      $filename,
      $instrumentId
    ), true);
    return new InstrumentInfo($res);
  }
}