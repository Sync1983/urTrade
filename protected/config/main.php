<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'АвтоТехСнаб - Ваш поставщик запчастей',
          'language'=>'ru',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			'class' => 'WebUser',			
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=urTrade',
			'emulatePrepare' => true,
			'username' => 'atc58',
			'password' => 'test_pass',
			'charset' => 'utf8',
            ),
        'cache'=>array(
            'class'=>'ext.redis.CRedisCache',
            'servers'=>array(
                array(
                    'host'=>'127.0.0.1',
                    'port'=>6379,
                ),                                
            ),
        ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				//
				//array(
				//	'class'=>'CWebLogRoute',
				//),				
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'sales@atc58.ru',
                    'providers_data'=>array(
                        'ixora'=>array(
                            'login'=>'AVTOTEHS',
                            'pass'=>'6de6b09l',
                            'contract_id'=>'86951',
                        ),
                        /*'online'=>array(
                            'login'=>'6957659777',
                            'pass'=>'kdV2N5iD5w',
                        ),*/
                    ),
            ),
);