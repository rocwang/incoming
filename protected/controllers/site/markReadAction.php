<?php
class markReadAction extends CAction
{
	public function run($id)
	{
		$googleReader = new GoogleReaderAPI(
			Yii::app()->params['credentials']['googleReader']['username'],
			Yii::app()->params['credentials']['googleReader']['password']
		);

		$googleReader->set_state($id, 'read');

		echo json_encode( array(
				'status'=>200,
		));
	}
}
