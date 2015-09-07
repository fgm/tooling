<?php
/**
 * @file
 * ServiceDumperPass.php
 *
 * @author: Frédéric G. MARAND <fgm@osinet.fr>
 *
 * @copyright (c) 2015 Ouest Systèmes Informatiques (OSInet).
 *
 * @license General Public License version 2 or later
 */

namespace Drupal\tooling\ServicesGraph;


use Doctrine\Common\Util\Debug;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ServiceDumperPass implements CompilerPassInterface {
  public function process(ContainerBuilder $container) {
    Debug::dump($container);
  }

}
