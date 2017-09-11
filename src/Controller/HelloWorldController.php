<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Config\Config;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
   * @param string $name
   * @param Request $request
   *
   * @return Response
   */
  public function nameAction($name, Request $request) {
    // Not best practice to include HTML in the controller but this is for
    // demonstration purposes only.
    $information = [
      '<strong>Current path:</strong> ' . $request->getRequestUri(),
      '<strong>Request method:</strong> ' . $request->getMethod(),
      '<strong>IP Address:</strong> ' . $request->server->get('REMOTE_ADDR'),
      '<strong>User Agent:</strong> ' . $request->server->get('HTTP_USER_AGENT'),
    ];

    if (!empty($request->query->all())) {
      $information[] = '<strong>Query Paramters:</strong> '
        . '<pre>' . print_r($request->query->all(), TRUE) . '</pre>';
    }

    return new Response(
      sprintf(
        "Hi %s! Here's some information about your request: %s",
        $name,
        '<p>' . implode('<br>', $information) . '</p>'
      ),
      Response::HTTP_I_AM_A_TEAPOT
    );
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
