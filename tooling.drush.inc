<?php
/**
 * @file
 * Drush hook implementations for the Tooling module.
 */
use Doctrine\Common\Util\Debug;
use Drupal\Core\DrupalKernel;
use Drupal\tooling\RouteTree\Gatherer as LinksGatherer;
use Drupal\tooling\ServicesGraph\Gatherer as ServicesGatherer;
use Symfony\Component\DependencyInjection\IntrospectableContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Implements hook_drush_command().
 */
function tooling_drush_command() {
  $items = array();

  $items['tooling-links-tree'] = [
    'description' => 'Export the full link tree as a Graphviz "dot" file. Filter it through dot.',
    'aliases' => ['tolt'],
  ];

  $items['tooling-dic-dependencies'] = [
    'description' => 'Export the graph of DIC dependencies as a Graphviz "dot" file. Filter it through dot.',
    'aliases' => ['todd'],
  ];

  return $items;
}

/**
 * Command callback for tooling-links-tree.
 */
function drush_tooling_links_tree() {
  $gatherer = new LinksGatherer(realpath(getcwd()));
  $gatherer->scanDisk();
  echo $gatherer->dumpDigraph();
}

function drush_tooling_dic_dependencies() {
  $container = Drupal::getContainer();
  if (empty($container)) {
    return drush_set_error(dt('No container was found.'));
  }
  elseif (!($container instanceof IntrospectableContainerInterface)) {
    return drush_set_error(dt('Container is not introspectable.'));
  };

  $gatherer = new ServicesGatherer($container);
  echo $gatherer->dumpGraph();
}
