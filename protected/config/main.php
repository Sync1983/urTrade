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
	),
	// application components
	'components'=>array(
		'user'=>array(
			'class' => 'WebUser',			
			'allowAutoLogin'=>true,
		),
		'clientScript'=>array(
		  'packages' => array(
			// Уникальное имя пакета
			'datatable_q' => array(            
			  'baseUrl' => '/js/',            
			  'js'=>array(YII_DEBUG ? '/jquery.dataTables.js' : '/jquery.dataTables.min.js'),            
			  'depends'=>array('jquery'),
			),
		  )		  
        ),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=urTrade',
			'emulatePrepare' => true,
			'username' => 'urtrade',
			'password' => 'q2w3e4r5t6',
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
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'sales@atc58.ru',
                    'providers_data'=>array(
                    /*    'Ixora'=>array(
                            'login'=>'AVTOTEHS',
                            'pass'=>'6de6b09l',
                            'contract_id'=>'86951',
                        ),
                        'Online'=>array(
                            'login'=>'6957659777',
                            'pass'=>'kdV2N5iD5w',
                        ),
						'Forum'=>array(
                            'login'=>'/prices/forum',
                            'pass' =>''
                        ),*/
						'Armtek'=>array(
                            'login'=>'/prices/armtek',
                            'pass' =>''
                        )
                    ),
            ),
);
