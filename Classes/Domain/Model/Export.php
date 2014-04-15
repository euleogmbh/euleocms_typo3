<?php
class Tx_Euleo_Domain_Model_Export extends Tx_Extbase_DomainObject_AbstractEntity
{
	/**
	 * the filename
	 * 
	 * @var string
	 */
	protected $filename = '';
	
	/**
	 * @var string
	 */
	protected $content = '';
	
	/**
	 * @var int
	 */
	protected $date = 0;
	
	/**
	 * @var int
	 */
	protected $ready = 0;
	
	public function __construct($filename = '', $content = '')
	{
		$this->setFilename($filename);
		$this->setContent($content);
		$this->setDate(time());
	}
	
	public function getFilename()
	{
		return $this->filename;
	}
	public function setFilename($filename)
	{
		$this->filename = $filename;
	}
	
	public function getId()
	{
		return $this->uid;
	}
	
	public function getDate()
	{
		return $this->date;
	}
	public function setDate($date)
	{
		$this->date = $date;
	}
	
	public function getContent()
	{
		return $this->content;
	}
	
	public function setContent($content)
	{
		$this->content = $content;
	}
	
	public function getReady()
	{
		return $this->ready;
	}
	
	public function setReady($value)
	{
		$this->ready = $value;
	}
}