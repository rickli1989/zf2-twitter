<?php 
namespace Application\Model;

class Twitter
{
	public $id;
	public $text;
	public $created_at;
	public $user_id;

	public function exchangeArray($data)
	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->text = (!empty($data['text'])) ? $data['text'] : null;
		$this->created_at  = (!empty($data['created_at'])) ? $data['created_at'] : null;
		$this->user_id  = (!empty($data['user_id'])) ? $data['user_id'] : null;
	}
}

?>