<?php

namespace Drupal\dummy_scheduler;

class Utility {

  /**
   * Add to schedule.
   */
  public static function addToSchedule($nid) {
    $_SESSION['dummy_scheduler']['schedule'][$nid];
  }

}
