<?php
return array(
  'seo' => 
  array(
    'frontend' => 
    array(
      'site' => 'Nom Prénom Function',
      'title' => 'Nom Prénom',
      'detail' => 'Fonction détail',
      'copyright' => '©2018 Nom prénom ou société',
      'author' => 'Laurent Marques (efx) ©2018',
      'description' => 'Description',
      'keywords' => 'google meta mots clefs',
    ),
    'backend' => 
    array(
      'title' => 'Nom Prénom | Administration',
    ),
  ),
  'setup' => 
  array(
    'site' => 
    array(
      'default' => '',
      'background-color' => 'white',
      'order' => 'asc',
    ),
    'page' => 
    array(
      'truncate' => '200',
      'pagination'        => '20',
      'pagination_global' => '100',
    ),
    'services' => 
    array(
      'froala_editor_license' => 'xxxxxxxxxxx',
      'analytic_code' => 'UA-XXXXXXXXX-X',
      'mandrill_api' => '',
      'contact' => 'name@gmail.com',
    ),
    'footer' =>
      array(
        'line1' => 'Lien recommandé : <a href="http://sonsite.fr" class="nom" target="_blank">Nom Prénom</a> Sa fonction.',
        'line2' => '',
        'line3' => '',
      ),
  ),
  'assets' => NULL,
  'user_theme' => 
  array(
    'frontend' => 
    array(
      'template' => 'default',
      'asset' => 'voguart',
    ),
    'backend' => 
    array(
      'template' => 'default',
      'asset' => 'voguart',
    ),
    'test' => 
    array(
      'template' => 'default',
      'asset' => 'voguart',
    ),
  ),
);
