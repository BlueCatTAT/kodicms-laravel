<?php namespace KodiCMS\Widgets\Loader;

use Illuminate\Filesystem\Filesystem;

class WidgetLoader
{
	/**
	 * The filesystem instance.
	 *
	 * @var \Illuminate\Filesystem\Filesystem
	 */
	protected $files;

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * @var array
	 */
	protected $registeredWidgets = [];

	/**
	 * @param string Filesystem $files
	 * @param $path
	 */
	public function __construct(Filesystem $files, $path)
	{
		$this->path = $path;
		$this->files = $files;
	}

	public function init()
	{
		foreach ($this->getFilesystem()->directories($this->getPath()) as $path)
		{
			if (!file_exists($initFile = $path . DIRECTORY_SEPARATOR . 'init.php'))
			{
				continue;
			}

			$config = require $initFile;

			if (!isset($config['class']))
			{
				continue;
			}

			$this->registerWidget($path, $config);
		}

	}

	public function registerWidget($path, array $config)
	{
		$widgetName = pathinfo($path, PATHINFO_BASENAME);
		$this->registeredWidgets[$path] = [
			'name' => $widgetName,
			'config' => $config
		];

		$className = $config['class'];

//		app()->bind($className, new $className($path));
	}

	/**
	 * Get the filesystem instance.
	 *
	 * @return \Illuminate\Filesystem\Filesystem
	 */
	public function getFilesystem()
	{
		return $this->files;
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}
}