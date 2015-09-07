tooling
=======

Tooling for Drupal 8 development and auditing.

Current features
----------------

- Drush commands:
    - `tooling-menu-links-tree` alias `tolt`
        - Exports the tree of menu links on a site as a GraphViz dot file.
        - Run like: `drush tolt | dot -Tsvg > mysite.svg`
        - Look out for the orange orphan items: they are routes with no parent,
          meaning their path is not "hackable", which may be an error.
        - See http://blog.riff.org/2014_10_05_drupal_8_tip_of_the_day_check_menu_links_consistency 
    - `tooling-dic-dependencies` alias `todd`
        - Exports the graph (hopefully tree) of service dependencies as a GraphViz dot file
        - Run like: `drush todd | dot T-svg > mysite.svg`
        
License
-------

This module is licensed under the General Public License version 2 or later.
Check the LICENSE.txt file for details.
