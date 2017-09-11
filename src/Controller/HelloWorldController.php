<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Config\Config;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class HelloWorldController extends ControllerBase {

  /**
   * @var Config
   */
  protected $config;

  /**
   * HelloWorldController constructor.
   *
   * @param Config $config
   */
  public function __construct(Config $config) {
    $this->config = $config;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')->get('hello_world.settings')
    );
  }

  /**
   * @return array
   */
  public function indexAction() {
    return [
      '#markup' => $this->getMessage(),
    ];
  }

  /**
   * @return JsonResponse
   */
  public function jsonAction() {
    return new JsonResponse(['message' => $this->getMessage()]);
  }

  /**
   * Get the hello_world module message.
   *
   * @return string
   */
  protected function getMessage() {
    return $this->config->get('message') ?: 'No message set.';
  }

}
