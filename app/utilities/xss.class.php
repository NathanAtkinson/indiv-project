<?php

class xss {

  public static function protection($value) {
    return htmlentities($value);
  }

}
