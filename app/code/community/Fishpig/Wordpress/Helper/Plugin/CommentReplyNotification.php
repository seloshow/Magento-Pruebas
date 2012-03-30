<?php
/**
 * @category    Fishpig
 * @package     Fishpig_Wordpress
 * @license     http://fishpig.co.uk/license.txt
 * @author      Ben Tideswell <help@fishpig.co.uk>
 */

class Fishpig_Wordpress_Helper_Plugin_CommentReplyNotification extends Fishpig_Wordpress_Helper_Plugin_Abstract
{
	/**
	 * Notify all previous commenters about a new comment
	 *
	 * @param Fishpig_Wordpress_Model_Post_Comment $comment
	 */
	public function notify(Fishpig_Wordpress_Model_Post_Comment $comment)
	{
		if ($this->isEnabled() && $comment->getPost()->getCommentCount() > 1) {
		
			// Load a collection of applicable comments
			$collection = Mage::getResourceModel('wordpress/post_comment_collection');
			
			$collection->addPostIdFilter($comment->getPostId());
			
			if ($comment->getUserId()) {
				$collection->addUserIdFilter(array('neq' => $comment->getUserId()));
			}
	
			$collection->addCommentAuthorEmailFilter(array('neq' => $comment->getCommentAuthorEmail()));
			
			if ($this->canDisplayOptIn()) {
				$collection->getSelect()->where('comment_mail_notify=?', 1);
			}
			
			$collection->addOrderByDate('asc');
	
			$collection->addCommentApprovedFilter();
			
			$collection->load();

			// Determine whether to check for Admin or post author
			$checkUserStatus = $this->getPluginOption('mail_notify') == 'admin';

			// Store emails already notified to stop duplicates being sent
			// to users with multiple comments
			$emailsNotified = array();
			
			foreach($collection as $oldComment) {
				if (!$checkUserStatus || $newComment->getUserId() == $newComment->getPostId()) {
					if (!in_array($oldComment->getCommentAuthorEmail(), $emailsNotified)) {
						$emailsNotified[] = $oldComment->getCommentAuthorEmail();
	
						$this->_notify($oldComment, $comment);
					}
				}
			}
		}
	}
	
	/**
	 * Notify the user from oldComment about newComment
	 *
	 * @param Fishpig_Wordpress_Model_Post_Comment $oldComment
	 * @param Fishpig_Wordpress_Model_Post_Comment $newComment
	 * @return bool
	 */
	protected function _notify(Fishpig_Wordpress_Model_Post_Comment $oldComment, Fishpig_Wordpress_Model_Post_Comment $newComment)
	{
		$subject = $this->getPluginOption('mail_subject');
		$body = $this->getPluginOption('mail_message');

		if ($body) {
			$mailVars = array(
				'blogname' => Mage::helper('wordpress')->getWpOption('blogname'),
				'blogurl' => Mage::helper('wordpress')->getUrl(),
				'postname' => $newComment->getPost()->getPostTitle(),
				'pc_content' => trim($oldComment->getCommentContent()),
				'pc_author' => $oldComment->getCommentAuthor(),
				'pc_date' => $oldComment->getCommentDate(),
				'cc_content' => trim($newComment->getCommentContent()),
				'cc_author' => $newComment->getCommentAuthor(),
				'cc_date' => $newComment->getCommentDate(),
				'cc_url' => $newComment->getCommentAuthorUrl(),
				'commentlink' => $newComment->getUrl(),
			);
			
			foreach($mailVars as $mailVar => $value) {
				$subject = preg_replace('/(\[' . $mailVar . '\])/i', $value, $subject);
				$body = preg_replace('/(\[' . $mailVar . '\])/i', $value, $body);
			}

			$mail = new Zend_Mail();
			$mail->setBodyHtml($body);
			$mail->setFrom(Mage::getStoreConfig('trans_email/ident_general/email'), Mage::getStoreConfig('trans_email/ident_general/name'));
			$mail->addTo($oldComment->getCommentAuthorEmail());
			$mail->setSubject($subject);
			
			try {
				$mail->send();		
				return true;
			}
			catch (Exception $e) {
				Mage::helper('wordpress')->log($e->getMessage());
			}
		}
		
		return false;
	}
	
	/**
	 * Determine whether to display the opt in
	 *
	 * @return bool
	 */
	public function canDisplayOptIn()
	{
		return $this->isEnabled() 
			&& in_array($this->getPluginOption('mail_notify'), array('parent_check', 'parent_uncheck'));
	}
	
	/**
	 * Determine whether the opt in is checked by default
	 *
	 * @return bool
	 */
	public function isOptInChecked()
	{
		return $this->getPluginOption('mail_notify') == 'parent_check';
	}
	
	/**
	 * Determine whether the plugin is enabled
	 *
	 * @return bool
	 */
	public function isEnabled()
	{
		return Mage::helper('wordpress')->isPluginEnabled('comment-reply-notification')
			&& $this->getPluginOption('mail_notify') != 'none';
	}
	
	/**
	 * Retrieve the options for this plugin
	 *
	 * @param string $key = null
	 * @return null|array
	 */
	public function getPluginOptions()
	{
		if (is_null($this->_options)) {
			$this->_options = array();

			if ($options = Mage::helper('wordpress')->getWpOption('commentreplynotification')) {
				$this->_options = unserialize($options);
			}
		}

		return $this->_options;
	}
	
	/**
	 * Retrieve a specific plugin option
	 *
	 * @param string $key
	 * @return string
	 */
	public function getPluginOption($key, $default = null)
	{
		if ($options = $this->getPluginOptions()) {
			return isset($options[$key]) ? $options[$key] : $default;
		}
		
		return $default;
	}
}
