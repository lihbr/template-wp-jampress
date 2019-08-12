<?php
/**
 * Add JAMPress headers gestion
 *
 * @return void
 */
function jamPress_theme_init() {
  JAMPress::addDefaultCORSHeaders();
  if (!PRODUCTION) {
    JAMPress::$allowed_origins[] = '*';
  } else {
    JAMPress::$allowed_origins[] = 'https://example.com';
  }
}
add_action('jampress_init', 'jamPress_theme_init');
