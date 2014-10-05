<?php
/**
 * @file
 * Gatherer.php
 *
 * @author: Frédéric G. MARAND <fgm@osinet.fr>
 *
 * @copyright (c) 2014 Ouest Systèmes Informatiques (OSInet).
 *
 * @license General Public License version 2 or later
 */

namespace Drupal\tooling\RouteTree;

use Symfony\Component\Yaml\Yaml;

class Gatherer {
  const MENU_LINKS_FILE_MASK = '/\.links\.menu\.yml$/';

  /**
   * @var string
   */
  protected $base_path;

  /**
   * @var array
   */
  protected $nodes;

  /**
   * @param string $base_path
   */
  public function __construct($base_path) {
    $this->base_path = $base_path;
    $this->nodes = array();
  }

  public function scanDisk() {
    $files = file_scan_directory($this->base_path, static::MENU_LINKS_FILE_MASK);
    foreach ($files as $path => $file) {
      $parsed = (array) Yaml::parse(file_get_contents($path));
      foreach ($parsed as $link => $link_info) {
        $this->nodes[$link] = NULL;
        if (isset($link_info['parent'])) {
          $this->nodes[$link] = $link_info['parent'];
        }
      }
    }
  }

  public function dumpDigraph() {
    $prefix = <<<EOT
digraph drupal {
  rankdir = RL;
  node [ shape="none" ];

EOT;

    $suffix = <<<EOT
}

EOT;

    $rows = array($prefix);
    foreach ($this->nodes as $link => $parent) {
      if (isset($parent)) {
        $rows[] = '  "' . $link . '" -> "' . $parent . '";';
      }
      else {
        $rows[] = '  "' . $link . '" [ fontcolor="orange" ];';
      }
    }
    $rows[] = $suffix;

    return implode("\n", $rows);
  }
}
