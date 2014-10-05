<?php
/**
 * @file
 * Drush hook implementations for the Tooling module.
 */
use Drupal\tooling\RouteTree\Gatherer;

/**
 * Implements hook_drush_command().
 */
function tooling_drush_command() {
  $items = array();

  $items['tooling-links-tree'] = array(
    'description' => 'Export the full link tree as a Graphviz "dot" file. Filter it through dot ',
    'aliases' => array('tolt'),
  );

  return $items;
}

/**
 * Command callback for tooling-links-tree.
 */
function drush_tooling_links_tree() {
  $gatherer = new Gatherer(realpath(getcwd()));
  $gatherer->scanDisk();
  echo $gatherer->dumpDigraph();
}
