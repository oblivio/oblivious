<?php
require 'sub_modules/slimphp/Slim/Slim.php';
require 'lib/oblivious.php';
error_reporting(E_ALL);
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
		'templates.path' => './html/oblivious'
));
// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app,$oblivious) {
	$app->config(array(
			'log.enable' => true,
			'debug' => true
	));
});

//We can inject the $app variable into the callback function with the use keyword:
$app->get('/', function () use ($app,$oblivious) {
	$view_data = array( 'js_path'=>'/code/oblivious/html/oblivious/js/all.js', 'nav_breadcrumb'=>'', 'path_from_index' => '/code/oblivious/html/oblivious/','nav_path'=>'/code/oblivious/');
	$app->render('html_top.php', $view_data);
	
	$app->render('oblivious.php', $view_data);
	$app->render('html_bottom.php', $view_data);
	
});
$app->get('/view/add/', function () use ($app,$oblivious) {
	$view_data = array( 'js_path'=>'/code/oblivious/html/oblivious/js/add.js', 'nav_breadcrumb'=>':add', 'path_from_index' => '/code/oblivious/html/oblivious/','nav_path'=>'/code/oblivious/');
	$app->render('html_top.php', $view_data);
	$app->render('add-entry.php', $view_data);
	$app->render('html_bottom.php', $view_data);
	
});
$app->get('/view/settings/', function () use ($app,$oblivious) {
	$view_data =  array( 'js_path'=>'/code/oblivious/html/oblivious/js/settings.js', 'nav_breadcrumb'=>':settings', 'path_from_index' => '/code/oblivious/html/oblivious/','nav_path'=>'/code/oblivious/');
	$app->render('html_top.php',$view_data);
	
	$app->render('settings.php', $view_data);
	
	$app->render('html_bottom.php', $view_data);
	
});
	$app->get('/view/settings/admin/', function () use ($app,$oblivious) {
		$view_data =  array( 'js_path'=>'/code/oblivious/html/oblivious/js/settings.js', 'nav_breadcrumb'=>':settings', 'path_from_index' => '/code/oblivious/html/oblivious/','nav_path'=>'/code/oblivious/');
		$app->render('html_top.php',$view_data);
	
		$app->render('settings-admin.php', $view_data);
	
		$app->render('html_bottom.php', $view_data);
	
	});
$app->post('/api/create/entry/',function() use ($app,$oblivious){
	if(ISSET($_POST['data'])){
		echo json_encode( $oblivious->createEntry() );
	}
	else{
		echo "Fail";
	}
});
$app->post('/api/get/entry/',function() use ($app,$oblivious){
	if(ISSET($_POST['entry_id']) && ISSET($_POST['category'])){
		echo json_encode( $oblivious->getEntry($_POST['entry_id'], $_POST['category']) );
	}
	else{
		echo "Fail";
	}
});
	$app->post('/api/get/entry/meta/',function() use ($app,$oblivious){
		if(ISSET($_POST['entry_id']) && ISSET($_POST['category'])){
			echo json_encode( $oblivious->getEntry($_POST['entry_id'], $_POST['category']), true );
		}
		else{
			echo "Fail";
		}
	});
$app->post('/api/remove/entry/',function() use ($app,$oblivious){
	if(ISSET($_POST['entry_id']) && ISSET($_POST['delete_token']) && ISSET($_POST['category'])){
		
		echo json_encode( $oblivious->deleteEntry($_POST['entry_id'],$_POST['delete_token'],$_POST['category']) );
	}
	else{
		echo "Fail";
	}
});
$app->get('/api/list/categories/',function() use ($app,$oblivious){
	
	echo json_encode( $oblivious->getCategories() );
	
});
$app->get('/api/add/categories/:category/',function($category) use ($app,$oblivious){

	echo json_encode( $oblivious->createCategory($category) );

});
$app->get('/api/remove/categories/:category/',function($category) use ($app,$oblivious){

	echo json_encode( $oblivious->removeCategory($category) );

});
$app->get('/api/list/entries/',function() use ($app,$oblivious){
	
	echo json_encode( $oblivious->listEntries() ); //json_encode
	
});
$app->post('/api/blackbook/',function() use ($app,$oblivious){
	//$blackbookdata = array(array('entryid'=>'', 'category'=>'beta','commentcount'=>1),'377089e832c66dd6'=>array('category'=>'beta','commentcount'=>5)) ;
	if(ISSET($_POST['blackbookdata'])){
		$blackbookdata = $_POST['blackbookdata'];
	}
	echo json_encode( $oblivious->blackbook($blackbookdata) );
});
$app->post('/api/list/entries/:category/meta/',function($category) use ($app,$oblivious){
	if(ISSET($_POST['metadata'])){
		$meta = json_decode($_POST['metadata'],true);
		if(count($meta) > 0){
			echo json_encode( $oblivious->listEntries($category, $meta )); //json_encode
		}
	}else{
		echo json_encode( array('Error'=>'No metadata passed.') );		
	}
});
$app->post('/api/list/entries/meta/',function() use ($app,$oblivious){
	if(ISSET($_POST['metadata'])){
		$meta = json_decode($_POST['metadata'],true);
		if(count($meta) > 0){
			echo json_encode( $oblivious->listEntries('', $meta )); //json_encode
		}
	}else{
		echo json_encode( array('Error'=>'No metadata passed.') );
	}
});

$app->get('/api/list/entries/:category/',function($category) use ($app,$oblivious){

	echo json_encode( $oblivious->listEntries($category) ); //json_encode

});
$app->get('/api/get/publickeys/:category/',function($category) use ($app,$oblivious){
	$res = $oblivious->getCategoryPublicKey($category); //json_encode
	echo json_encode( array('Key'=>$res) );
});
$app->error(function (\Exception $e) use ($app) {
	print_r($e);echo "yeah";
});
$app->run();
