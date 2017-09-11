<?php

namespace Drupal\hello_world\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class JsonResponseListener implements EventSubscriberInterface {

  /**
   * Set pretty print for all JSON response encoding options.
   *
   * @param FilterResponseEvent $event
   */
  public function onKernelResponse(FilterResponseEvent $event) {
    $response = $event->getResponse();

    if (!$response instanceof JsonResponse) {
      return; // bail, only alter JSON responses.
    }

    // Pretty print all JSON responses.
    $response->setEncodingOptions(JSON_PRETTY_PRINT);
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::RESPONSE => [['onKernelResponse', 0]],
    ];
  }

}
