<?php
error_reporting(E_ALL);
//force www
if ((strpos($_SERVER['HTTP_HOST'], 'www.') === false))
{
	//header('Location: http://www.'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
	//exit();
}


require 'sub_modules/slimphp/Slim/Slim.php';
require 'lib/oblivious.php';
$oblivious_settings=array(
		//'app_name'=>'other_app_name',
		'mode' => 'development',
		'meta_tags'=>array('isinvite','nickname','syntaxcoloring')
);
$oblivious = new \Oblivious\Oblivious(array($oblivious_settings));


\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim(array(
    'cookies.encrypt' => true,
		'mode' => 'development',
));
// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app,$oblivious) {
	$app->config(array(
			'log.enable' => true,
			'debug' => true
	));
});

	
$app->post('/api/create/entry/',function() use ($app,$oblivious){
	if(ISSET($_POST['data'])){
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");

		//header("Access-Control-Allow-Origin: *");
		echo json_encode( $oblivious->createEntry() );
	}
	else{
		echo "Fail";
	}
});
$app->post('/api/get/entry/',function() use ($app,$oblivious){
	if(ISSET($_POST['entry_id']) && ISSET($_POST['category'])){
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");

// 		header("Access-Control-Allow-Origin: *");
		echo json_encode( $oblivious->getEntry($_POST['entry_id'], $_POST['category']) );
	}
	else{
		echo "Fail";
	}
});
	$app->post('/api/get/entry/meta/',function() use ($app,$oblivious){
		if(ISSET($_POST['entry_id']) && ISSET($_POST['category'])){
			header('Content-Type: application/json');
			header("Access-Control-Allow-Origin: *");

// 			header("Access-Control-Allow-Origin: *");
			echo json_encode( $oblivious->getEntry($_POST['entry_id'], $_POST['category']), true );
		}
		else{
			echo "Fail";
		}
	});
	$app->get('/api/views/basic',function() use ($app,$oblivious){
		$result = array(
				'user_hash'=>hash('md5',$_SERVER['REMOTE_ADDR']),
				'category_data'=>$oblivious->getCategories()
				);
		echo json_encode($result);
	});
$app->post('/api/remove/entry/',function() use ($app,$oblivious){
	if(ISSET($_POST['entry_id']) && ISSET($_POST['delete_token']) && ISSET($_POST['category'])){
		header('Content-Type: application/json');
// 		header("Access-Control-Allow-Origin: *");
		echo json_encode( $oblivious->deleteEntry($_POST['entry_id'],$_POST['delete_token'],$_POST['category']) );
	}
	else{
		echo "Fail";
	}
});
$app->get('/api/list/categories/',function() use ($app,$oblivious){
	header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");

// 	header("Access-Control-Allow-Origin: *");
	echo json_encode( $oblivious->getCategories() );
	
});
$app->get('/api/add/categories/:category/',function($category) use ($app,$oblivious){
	header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");

// 	header("Access-Control-Allow-Origin: *");
	echo json_encode( $oblivious->createCategory($category) );

});
$app->get('/api/remove/categories/:category/',function($category) use ($app,$oblivious){
	header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");

// 	header("Access-Control-Allow-Origin: *");
	echo json_encode( $oblivious->removeCategory($category) );

});
$app->get('/api/list/entries/',function() use ($app,$oblivious){
	header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");

// 	header("Access-Control-Allow-Origin: *");
	echo json_encode( $oblivious->listEntries() ); //json_encode
	
});
$app->post('/api/blackbook/',function() use ($app,$oblivious){
	//$blackbookdata = array(array('entryid'=>'', 'category'=>'beta','commentcount'=>1),'377089e832c66dd6'=>array('category'=>'beta','commentcount'=>5)) ;
	if(ISSET($_POST['blackbookdata'])){
		$blackbookdata = $_POST['blackbookdata'];
		header("Access-Control-Allow-Origin: *");
		header('Content-Type: application/json');
		echo json_encode( $oblivious->blackbook($blackbookdata) );
	}else{
		header("Access-Control-Allow-Origin: *");
	}
});
$app->post('/api/list/entries/:category/meta/',function($category) use ($app,$oblivious){
	if(ISSET($_POST['metadata'])){
		$meta = json_decode($_POST['metadata'],true);
		if(count($meta) > 0){
			header('Content-Type: application/json');
			header("Access-Control-Allow-Origin: *");
			echo json_encode( $oblivious->listEntries($category, $meta )); //json_encode
		}
	}else{
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
		echo json_encode( array('Error'=>'No metadata passed.') );		
	}
});
$app->post('/api/list/entries/meta/',function() use ($app,$oblivious){
	if(ISSET($_POST['metadata'])){
		$meta = json_decode($_POST['metadata'],true);
		if(count($meta) > 0){
			header('Content-Type: application/json');
			header("Access-Control-Allow-Origin: *");
			echo json_encode( $oblivious->listEntries('', $meta )); //json_encode
		}
	}else{
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
		echo json_encode( array('Error'=>'No metadata passed.') );
	}
});

$app->get('/api/list/entries/:category/',function($category) use ($app,$oblivious){
	header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
	echo json_encode( $oblivious->listEntries($category) ); //json_encode

});
$app->get('/api/get/publickeys/:category/',function($category) use ($app,$oblivious){
	$res = $oblivious->getCategoryPublicKey($category); //json_encode
	header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
	echo json_encode( array('Key'=>$res) );
});
$app->run();
