<?php
class listAction extends CAction
{
	public function run()
	{
		//$mails = $this->_getAllMails();
		$feeds = $this->_getFeeds();

		$this->controller->renderPartial(
			'json',
			array('data'=>array('items'=>$feeds))
);
	}

	/**
	 * _getFeeds Get unread google reader items
	 *
	 * @return void
	 */
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
}
