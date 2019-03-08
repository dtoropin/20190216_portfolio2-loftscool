<?php

class Templater
{
	protected static $instance = null;
	/**
	 * @var Twig_Loader_Filesystem
	 */
	protected $loader = null;
	/**
	 * @var Twig_Environment
	 */
	protected $twig = null;

	protected function __construct()
	{
	}

	protected function __clone()
	{
	}

	public static function getInstance()
	{
		if(is_null(self::$instance))
		{
			self::$instance = new self();
			self::$instance->setTemplateSettings();
		}

		return self::$instance;
	}

	protected function setTemplateSettings()
	{
		$this->loader = new Twig_Loader_Filesystem(__DIR__. '/../../views/');
		$this->twig = new Twig_Environment($this->loader);
	}

	public function display($template, $data = array())
	{
		return $this->twig->render($template.'.twig', $data);
	}
}