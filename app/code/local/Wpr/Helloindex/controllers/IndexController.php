<?php
class Wpr_Helloindex_IndexController extends Mage_Core_Controller_Front_Action {
	public function indexAction()
	{ 
		$this->loadLayout();
		//echo 'hello index';
		$this->renderLayout();
		//Mage::log(Mage::getConfig(),0,'system.log');
		//var_export(Mage::getConfig());exit;
	}
	public function goodbyeAction()
	{
		echo 'goodbye';
	}
	public function newpostAction()
	{
		$post=Mage::getModel('helloindex/blogpost');
		$post->setBlogTitle("cadena");
		$post->save();
		
	}
	public function loadpostAction()
	{
	$post=Mage::getModel('helloindex/blogpost')->load(1);
	//$post=new  Wpr_Helloindex_Model_Blogpost();
	$post->load(1);
	echo $post->getBlogTitle();
	}
	public function showAllBlogPostsAction() {
	    $posts = Mage::getModel('helloindex/blogpost')->getCollection();
	    //var_dump($posts);
		foreach($posts as $blog_post){
	        echo '<h3>'.$blog_post->getBlogTitle().'</h3>';
	        
	    }
	}
	public function responseAction(){
		//var_dump(get_class($this->getResponse()));/*Pantalla: Mage_Core_Controller_Response_Http */
		//$this->loadLayout();
		//$this->renderLayout();
		$request = new Zend_Controller_Request_Apache404();
		//var_dump($this->_getRefererUrl());
		$patata=Mage::getSingleton('core/session')->getPatata();
		var_dump($patata);exit;
		
		
	}
}