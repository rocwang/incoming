<?php
class SiteController extends Controller
{
	public $defaultAction = 'list';

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

	private function _getMails($provider)
	{
		$mailbox  = Yii::app()->params['mailServerConfig'][$provider];
		$user     = Yii::app()->params['credentials'][$provider]['username'];
		$password = Yii::app()->params['credentials'][$provider]['password'];

		$inbox = imap_open($mailbox , $user , $password);

		/*imap_check returns information about the mailbox
		including mailbox name and number of messages*/
		$check = imap_check($inbox);

		/*imap_fetch_overview returns an overview for a message.
		  An overview contains information such as message subject,
		  sender, date, and if it has been seen. Note that it does
		  not contain the body of the message. Setting the second
		parameter to "1:n" will cause it to return a sequence of messages*/
		$overviews = imap_fetch_overview($inbox,"1:{$check->Nmsgs}");

		foreach ($overviews as &$mail) {
			$st = imap_fetchstructure($inbox, $mail->msgno);

			//CVarDumper::dump($st, 10, true);

			switch($st->type) {
			case TYPETEXT:
				$mail->body = $this->_decodeMail(
					$st->encoding,
					imap_body($inbox, $mail->msgno, FT_PEEK)
				);
				break;
			case TYPEMULTIPART:
				for ($i = 0, $j = count($st->parts); $i < $j; $i++) {
					$part = $st->parts[$i];
					if ($part->type === TYPETEXT) {
						$mail->body = $this->_decodeMail(
							$part->encoding,
							imap_fetchbody($inbox, $mail->msgno, $i+1)
						);
						break;
					}
				}
				break;
			default:
				$mail->body = 'UNKNOWN MIME TYPE';
				break;
			}
		}

		return $overviews;
	}

	private function _decodeMail($encoding, $body)
	{
		switch ($encoding) {
		case ENC7BIT:
			return $body;
		case ENC8BIT:
			return $body;
		case ENCBINARY:
			return $body;
		case ENCBASE64:
			return imap_base64($body);
		case ENCQUOTEDPRINTABLE:
			return imap_qprint($body);
		case ENCOTHER:
			return $body;
		default:
			return $body;
		}
	}

	private function _getAllMails()
	{
		$gmail  = $this->_getMails('googleMail');
		$qqmail = $this->_getMails('qqMail');

		$overviews = array_merge(
			$qqmail,
			$gmail
		);

		return $overviews;
	}

	private function _getFeeds()
	{
		$googleReader = new GoogleReaderAPI(
			Yii::app()->params['credentials']['googleReader']['username'],
			Yii::app()->params['credentials']['googleReader']['password']
		);

		//get first 10 unread items from google reader
		$unreadItems = $googleReader ->get_unread(10);

		//CVarDumper::dump($unreadItems, 10, true);die;

		return $unreadItems->items;
	}

	public function actionDebug()
	{
		$googleReader = new GoogleReaderAPI(
			Yii::app()->params['credentials']['googleReader']['username'],
			Yii::app()->params['credentials']['googleReader']['password']
		);

		$unreadItems = $googleReader ->get_unread(10);

		CVarDumper::dump($unreadItems, 10, true);
	}

	public function actionList()
	{
		$mails = $this->_getAllMails();
		//$mails = array();
		$feeds = $this->_getFeeds();

		$this->render('list', array(
			'mails' => $mails,
			'feeds' => $feeds,
		));
	}

	public function actionRead($uid)
	{
		$host = 'imap.qq.com:143';
		$user = '11712219@qq.com';
		$password = '120784lyl!';
		$mailbox = "{{$host}}INBOX";
		$inbox = imap_open($mailbox , $user , $password);

		$overview = imap_fetch_overview($inbox, $uid, FT_UID);
		$body = imap_body($inbox, $uid, FT_UID);

		require_once 'Mail/mimeDecode.php';
		$params['include_bodies'] = true;
		$params['decode_bodies']  = true;
		$params['decode_headers'] = false;

		$decoder = new Mail_mimeDecode($body);
		$structure = $decoder->decode($params);

		$this->render('read', array('overview'=>$overview[0], 'body'=>$body));
	}
}
