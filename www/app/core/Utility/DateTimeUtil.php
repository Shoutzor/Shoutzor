<?php

namespace Shoutzor\Utility;

use \DateTime;

 class DateTimeUtil {

  private DateTime $value;

  public function __construct(DateTime $input)
  {
    $this->value = $input;
  }

  public function formatAs($format): string
  {
    return $this->value->format($format);
  }

  public static function isDate($input): bool
  {
    return ($input instanceof PHPDateTime);
  }

  public static function toDate($input, $format): PHPDateTime
  {
    return PHPDateTime::createFromFormat($format, $input);
  }

}
