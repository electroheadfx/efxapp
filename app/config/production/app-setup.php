<?php
return array(
  'seo' => 
  array(
    'frontend' => 
    array(
      'site' => 'Stéphanie Varela Artiste',
      'title' => 'Stéphanie Varela',
      'detail' => 'Réalisatrice/Plasticienn',
      'copyright' => '©2019 Stéphanie Varela',
      'author' => 'Laurent Marques (efx) ©2019',
      'description' => 'Stéphanie Varela Réalisatrice et Plasticienne',
      'keywords' => 'varela, peinture animée, Stéphanie Varela, STEPHANIE VARELA, VARELA, stéphanie',
    ),
    'backend' => 
    array(
      'title' => 'Stéphanie Varela | Administration',
    ),
  ),
  'setup' => 
  array(
    'site' => 
    array(
      'default' => 'test/0',
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
      'froala_editor_license' => '2ecB-16irzrtH-8iasgoeG4bbI-7==',
      'analytic_code' => 'UA-XXXXXXXXX-X',
      'mandrill_api' => '',
      'contact' => 'readymadelefilm@gmail.com',
    ),
    'footer' =>
      array(
        'line1' => 'Lien recommandé : <a href="http://josselinbillot.com" class="nom" target="_blank">Josselin Billot</a> Directeur de la photographie.',
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
      'asset' => 'varela',
    ),
    'backend' => 
    array(
      'template' => 'default',
      'asset' => 'varela',
    ),
    'test' => 
    array(
      'template' => 'default',
      'asset' => 'varela',
    ),
  ),
);
