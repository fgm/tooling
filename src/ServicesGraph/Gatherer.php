<?php
/**
 * @file
 * Gatherer.php
 *
 * @author: Frédéric G. MARAND <fgm@osinet.fr>
 *
 * @copyright (c) 2015 Ouest Systèmes Informatiques (OSInet).
 *
 * @license General Public License version 2 or later
 */

namespace Drupal\tooling\ServicesGraph;


use Doctrine\Common\Util\Debug;
use Drupal\Core\DrupalKernel;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\IntrospectableContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class Gatherer {

  /**
   * @var \Symfony\Component\DependencyInjection\IntrospectableContainerInterface
   */
  protected $container;

  public function __construct(IntrospectableContainerInterface $container) {
    $this->container = $container;
  }

  /**
   * Derived from DrupalKernelTest::getTestKernel().
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *
   * @return static
   * @throws \Exception
   */
  public function getDumperKernel(Request $request) {
    $read_only = TRUE;
    $modules_enabled = [];

    // Manually create kernel to avoid replacing settings.
    $class_loader = require DRUPAL_ROOT . '/autoload.php';
    $kernel = DrupalKernel::createFromRequest($request, $class_loader, 'dev');
    $this->settingsSet('container_yamls', []);
    $this->settingsSet('hash_salt', $this->databasePrefix);

    if (isset($modules_enabled)) {
      $kernel->updateModules($modules_enabled);
    }
    $kernel->boot();

    if ($read_only) {
      $php_storage = Settings::get('php_storage');
      $php_storage['service_container']['class'] = 'Drupal\Component\PhpStorage\FileReadOnlyStorage';
      $this->settingsSet('php_storage', $php_storage);
    }
    return $kernel;
  }

  public function dumpGraph() {
    $dic = $this->container;
    $ids = $dic->getServiceIds();
    $cl = $dic->get('container.namespaces');
      Debug::dump($cl);
    $res = <<<DOT
digraph dic_dependencies {
$graph
}

DOT;

    return $res;
  }
}
