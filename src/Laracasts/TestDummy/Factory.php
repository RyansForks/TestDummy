<?php namespace Laracasts\TestDummy;

use Symfony\Component\Yaml\Yaml;

/**
 * Convenience Laravel bootstrap for TestDummy
 * Factory::times(2)->create('Post')
 *
 * @package Laracasts\TestDummy
 */
class Factory {

	/**
	 * The path to the fixtures file
	 *
	 * @var array
	 */
	protected static $fixtures;

	/**
	 * Persistence layer
     *
     * @var BuildableRepositoryInterface
	 */
	protected static $databaseProvider;

	/**
	 * Create a new Builder instance.
	 *
	 * @return Builder
	 */
	protected static function getInstance()
	{
		if ( ! static::$fixtures) static::setFixtures();
		if ( ! static::$databaseProvider) static::setDatabaseProvider();

		return new Builder(static::$databaseProvider, static::$fixtures);
	}

	/**
	 * Fill an entity with test data, without saving it.
	 *
	 * @param string $type
	 * @param array  $attributes
	 * @return array
	 */
	public static function build($type, array $attributes = [])
	{
		return static::getInstance()->build($type, $attributes);
	}

	/**
	 * Fill and save an entity.
	 *
	 * @param string $type
	 * @param array  $attributes
	 * @return mixed
	 */
	public static function create($type, array $attributes = [])
	{
		return static::getInstance()->create($type, $attributes);
	}

	/**
	 * Set the number of times to create a record.
	 *
	 * @param $times
	 * @return $this
	 */
	public static function times($times)
	{
		return static::getInstance()->setTimes($times);
	}

	/**
	 * Set the fixtures path
	 *
	 * @param $basePath
	 */
	public static function setFixtures($basePath = null)
	{
		$basePath = $basePath ?: app_path('tests');

		$finder = new FixturesFinder($basePath);

		static::$fixtures = Yaml::parse($finder->find());
	}

	/**
	 * Set the database provider
	 *
	 * @param null $provider
	 * @return EloquentDatabaseProvider
	 */
	public static function setDatabaseProvider($provider = null)
	{
		$provider = $provider ?: new EloquentDatabaseProvider;

		return static::$databaseProvider = $provider;
	}

} 