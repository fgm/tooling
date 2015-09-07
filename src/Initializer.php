<?php

/**
 * @file
 * Initializer.php
 *
 * @author: Frédéric G. MARAND <fgm@osinet.fr>
 *
 * @copyright (c) 2015 Ouest Systèmes Informatiques (OSInet).
 *
 * @license General Public License version 2 or later
 */

namespace Drupal\tooling;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class Initializer forces session cookies not to be HTTP Only.
 */
class Initializer implements EventSubscriberInterface {
  const VAR_NAME = 'session.cookie_httponly';

  protected $savedHttpOnly;

  /**
   * Event handler for Request.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *   The request event.
   */
  public function onRequest(GetResponseEvent $event) {
    $this->savedHttpOnly = ini_get(static::VAR_NAME);
    ini_set(static::VAR_NAME, 0);
  }

  /**
   * Event handler for Terminate.
   *
   * @param \Symfony\Component\HttpKernel\Event\PostResponseEvent $event
   *   The terminate event.
   */
  public function onTerminate(PostResponseEvent $event) {
    ini_set(static::VAR_NAME, $this->savedHttpOnly);
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $ret = [
      KernelEvents::REQUEST => ['onRequest'],
      KernelEvents::TERMINATE => ['onTerminate'],
    ];
    return $ret;
  }
}
