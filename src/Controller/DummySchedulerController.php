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
   * addToScheduler.
   *
   * @return array
   *   Return addto schedule.
   */
  public function addToSchedule($nid) {

    if (!in_array($nid, $_SESSION['dummy_scheduler']['schedule'])) {
      Utility::addToSchedule($nid);

      $node = Node::load($nid);

      $_SESSION['dummy_scheduler']['schedule'][$nid] = [
        'title' => $node->label(),
        'url' => $node->toUrl()->toString()
      ];
    }

    return [
      '#theme' => 'dummy_scheduler',
      '#items' => $_SESSION['dummy_scheduler']['schedule'],
    ];

  }

  /**
   * viewScheduler.
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

  public function resetSchedule() {
    $_SESSION['dummy_scheduler']['schedule'] = [];
    $items = [];

    return [
      '#theme' => 'dummy_scheduler',
      '#items' => $items,
    ];
  }

}
