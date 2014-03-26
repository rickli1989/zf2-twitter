<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;
use Application\Model\Twitter;
use Application\Model\User;

class IndexController extends AbstractActionController
{
	protected $twitterTable;
    protected $userTable;

    public function indexAction()
    {
    	$out = array();
    	$results = $this->getTwitterTable()->fetchAll();
    	foreach ($results as $key => $value) {
    		$out[] = (array)$value;
    	}

        return new ViewModel(array('tweets'=>str_replace("'", "\\'", json_encode($out,JSON_NUMERIC_CHECK))));
    }

    public function getTwitterTable()
     {
         if (!$this->twitterTable) {
             $sm = $this->getServiceLocator();
             $this->twitterTable = $sm->get('Application\Model\TwitterTable');
         }
         return $this->twitterTable;
     }

     public function getUserTable()
     {
         if (!$this->userTable) {
             $sm = $this->getServiceLocator();
             $this->userTable = $sm->get('Application\Model\UserTable');
         }
         return $this->userTable;
     }

     protected function getTwitterFeeds($screen_name, $oauth_consumer_key, $oauth_nonce, $oauth_signature, $oauth_token, $timestamp){
     	$result = exec ("curl --get 'https://api.twitter.com/1.1/statuses/user_timeline.json' --data 'screen_name=".$screen_name."' --header 'Authorization: OAuth oauth_consumer_key=\"".$oauth_consumer_key."\", oauth_nonce=\"".$oauth_nonce."\", oauth_signature=\"".$oauth_signature."\", oauth_signature_method=\"HMAC-SHA1\", oauth_timestamp=\"".$timestamp."\", oauth_token=\"".$oauth_token."\", oauth_version=\"1.0\"' --verbose");
        if($result && !empty($result)){

            $userObj = $this->getUserTable()->getUserByName($screen_name);
            if(!$userObj){

                $user = new User();
                $data = array();
                $data['name'] = $screen_name;
                $user->exchangeArray($data);

                $lastInsertUserId = $this->getUserTable()->saveUser($user);
            }else{
                $lastInsertUserId = $userObj->id;
            }
            
            foreach(json_decode($result) as $key=>$value){
        		$text = $value->text;
    			$created_at = date("Y-m-d H:i:s", strtotime($value->created_at)); 
        		$twitter = new Twitter();
        		$data = array();
        		$data['text'] = $text;
        		$data['created_at'] = $created_at;
                $data['user_id'] = $lastInsertUserId;
        		$twitter->exchangeArray($data);
        		$this->getTwitterTable()->saveTwitter($twitter);
        	}
            return array('status'=>'success');
        }else{
            return array('status'=>'error','msg'=>'Unable to fetch Twitter data');
        }
     }
    public function feedsAction(){
        if ($this->getRequest()->isPost()){
            $screen_name = $this->params()->fromPost('screen_name'); 
            $oauth_consumer_key = $this->params()->fromPost('oauth_consumer_key'); 
            $oauth_nonce = $this->params()->fromPost('oauth_nonce'); 
            $oauth_signature = $this->params()->fromPost('oauth_signature'); 
            $oauth_token = $this->params()->fromPost('oauth_token');
            $timestamp = $this->params()->fromPost('timestamp');  
            $feed = $this->getTwitterFeeds($screen_name, $oauth_consumer_key, $oauth_nonce, $oauth_signature, $oauth_token,$timestamp);
            if($feed['status'] == 'success')
                return $this->redirect()->toRoute('home',
                  array('controller'=>'IndexController',
                        'action' => 'index'));
            else{
                return new ViewModel(array('error'=>"Tweet feed API error"));
            }
        }else{
            return new ViewModel();
        }
        
    }
}
