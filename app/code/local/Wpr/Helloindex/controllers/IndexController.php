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
}