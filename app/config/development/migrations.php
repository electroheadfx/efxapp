<?php
return array(
  'version' => 
  array(
    'app' => 
    array(
      'default' => 
      array(
        0 => '001_create_auth_permission',
        1 => '002_create_auth_group_permission',
        2 => '003_create_images',
        3 => '004_create_images_metadata',
        4 => '005_create_category',
        5 => '006_create_post',
        6 => '007_create_posts_metadata',
        7 => '008_create_comment',
        8 => '009_modify_exposition_constraint_to_category',
        9 => '010_create_category_default_entry',
        10 => '011_create_category_post',
        11 => '012_modify_exposition_constraint_to_category_cms',
        12 => '013_modify_name_type_to_post',
        13 => '014_add_locked_field_to_post',
        14 => '015_create_categories_metadata',
        15 => '016_modify_value_to_postmetadata',
        16 => '017_add_visibility_field_to_category',
      ),
    ),
    'module' => 
    array(
      'media' => 
      array(
        0 => '001_media_create_cv',
        1 => '002_add_column_to_media_cv',
      ),
      'project' => 
      array(
        0 => '001_project_create_menus',
        1 => '002_project_create_menus_metadata',
        2 => '003_project_modify_menus_metadata',
      ),
    ),
    'package' => 
    array(
      'auth' => 
      array(
        0 => '001_auth_create_usertables',
        1 => '002_auth_create_grouptables',
        2 => '003_auth_create_roletables',
        3 => '004_auth_create_permissiontables',
        4 => '005_auth_create_authdefaults',
        5 => '006_auth_add_authactions',
        6 => '007_auth_add_permissionsfilter',
        7 => '008_auth_create_providers',
        8 => '009_auth_create_oauth2tables',
        9 => '010_auth_fix_jointables',
        10 => '011_auth_group_optional',
      ),
    ),
  ),
  'folder' => 'migrations/',
  'table' => 'migration',
  'flush_cache' => false,
);
