<?php
/**
 * @file
 * ServiceDumper.php
 *
 * @author: Frédéric G. MARAND <fgm@osinet.fr>
 *
 * @copyright (c) 2015 Ouest Systèmes Informatiques (OSInet).
 *
 * @license General Public License version 2 or later
 */

namespace Drupal\tooling;


use Doctrine\Common\Util\Debug;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ToolingServiceProvider.
 */
class ToolingServiceProvider implements ServiceProviderInterface {

  /**
   * Helper for getDependencies(): check arguments.
   *
   * @param \Symfony\Component\DependencyInjection\Definition $definition
   *   The service definition.
   *
   * @return array
   *   The arguments
   */
  protected function getServiceArguments(Definition $definition) {
    $arguments = $definition->getArguments();
    $service_arguments = [];
    foreach ($arguments as $argument) {
      if ($argument instanceof Reference) {
        $service_arguments[] = "$argument";
      }
    }
    return $service_arguments;
  }

  protected function getDependencies($id, Definition $definition) {
    $ret = [];
    // echo "Deps for $id:\n";
    if (!empty($service_arguments)) {
      $ret['arguments'] = $this->getServiceArguments($definition);
    }

    $ret = array_filter($ret, function($dependencies) {
      $ret = [];
      foreach ($dependencies as $key => $values) {
        // if ()
      }
    });
    return $ret;
  }

  /**
   * {@inheritdoc}
   */
  public function register(ContainerBuilder $container) {
    $graph = [];
    $definitions = $container->getDefinitions();
    $count = 0;
    ksort($definitions);
    foreach ($definitions as $id => $definition) {
      $dependencies = $this->getDependencies($id, $definition);
      $graph[$id] = $dependencies;
      $count++;
      if ($count > 10) {
        break;
      }
    }
    print_r($graph);
  }
}
