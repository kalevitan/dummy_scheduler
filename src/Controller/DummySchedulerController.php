<?php

namespace Drupal\dummy_scheduler\Controller;

use Drupal\node\Entity\Node;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Drupal\dummy_scheduler\Utility;

/**
 * Class DummySchedulerController.
 */
class DummySchedulerController extends ControllerBase {

  /**
   * addToSchedule.
   *
   * @param string
   *   Node id
   * @return array
   *   Return render array with items.
   */
  public function addToSchedule($nid) {
    if (isset($_SESSION['dummy_scheduler']['schedule'])) {
      if (!in_array($nid, $_SESSION['dummy_scheduler']['schedule'])) {
        // Add the node to the schedule.
        Utility::addToSchedule($nid);

        // Load the node based on nid.
        $node = Node::load($nid);

        // Store session data.
        $_SESSION['dummy_scheduler']['schedule'][$nid] = [
          'title' => $node->label(),
          'url' => $node->toUrl()->toString()
        ];
      }
    } else {
      $_SESSION['dummy_scheduler']['schedule'] = [];
    }

    return [
      '#theme' => 'dummy_scheduler',
      '#items' => $_SESSION['dummy_scheduler']['schedule'],
    ];

  }

  /**
   * viewSchedule.
   *
   * @return array
   *   Return schedule view.
   */
  public function viewSchedule() {
    if (!empty($_SESSION['dummy_scheduler']['schedule'])) {
      $items = $_SESSION['dummy_scheduler']['schedule'];
    } else {
      $items = [];
    }

    return [
      '#theme' => 'dummy_scheduler',
      '#items' => $items,
    ];

  }

  /**
   * resetSchedule.
   *
   * @return array
   *   Return empty schedule session.
   */
  public function resetSchedule() {
    $_SESSION['dummy_scheduler']['schedule'] = [];
    $items = [];

    return [
      '#theme' => 'dummy_scheduler',
      '#items' => $items,
    ];
  }

}
