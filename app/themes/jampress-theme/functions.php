<?php
define( 'THEME_PATH' ,          get_template_directory()            );
define( 'TEMPLATE_PATH' ,       THEME_PATH .   '/templates'         );
define( 'THEME_URL' ,           get_template_directory_uri()        );

// LOADING CORE FILES
$folders = array( 'core', 'posttypes', 'functions' );
foreach ($folders as $folder) {
  foreach ( glob( THEME_PATH . "/inc/$folder/*.php" ) as $file ) {
    include_once $file;
  }
}
