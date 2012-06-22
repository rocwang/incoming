<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionEmail()
	{
		$host = 'imap.qq.com:143';
		$user = '11712219@qq.com';
		$password = '120784@qq';
		$mailbox = "{{$host}}INBOX";
		$mbox = imap_open($mailbox , $user , $password);

		/*imap_check returns information about the mailbox
		  including mailbox name and number of messages*/
		$check = imap_check($mbox);

		/*imap_fetch_overview returns an overview for a message.
		  An overview contains information such as message subject,
		  sender, date, and if it has been seen. Note that it does
		  not contain the body of the message. Setting the second
		  parameter to "1:n" will cause it to return a sequence of messages*/
		$overviews = imap_fetch_overview($mbox,"1:{$check->Nmsgs}");

		$this->render('email', array('overviews'=>$overviews));
	}

	public function actionRead($uid)
	{
		$host = 'imap.qq.com:143';
		$user = '11712219@qq.com';
		$password = '120784@qq';
		$mailbox = "{{$host}}INBOX";
		$mbox = imap_open($mailbox , $user , $password);

		$overview = imap_fetch_overview($mbox, $uid, FT_UID);
		$body = imap_body($mbox, $uid, FT_UID);

		require_once 'Mail/mimeDecode.php';
		$params['include_bodies'] = true;
		$params['decode_bodies']  = true;
		$params['decode_headers'] = false;

		$decoder = new Mail_mimeDecode($body);
		$structure = $decoder->decode($params);

		$this->render('read', array('overview'=>$overview[0], 'body'=>$body));
	}
}
