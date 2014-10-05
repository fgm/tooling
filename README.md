tooling
=======

Tooling for Drupal 8 development and auditing.

Current features
----------------

- Drush command:
    - `tooling-menu-links-tree`
        - Exports the tree of menu links on a site as a GraphViz dot file.
        - Run like: `drush tolt | dot -Tsvg > mysite.svg`
        - Look out for the orange orphan items: they are routes with no parent,
          meaning their path is not "hackable", which may be an error.

License
-------

This module is licensed under the General Public License version 2 or later.
Check the LICENSE.txt file for details.
