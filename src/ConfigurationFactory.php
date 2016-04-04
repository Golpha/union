<?php
/**
 * This file is part of Union.
 * (c) 2016 Union maintainers, All rights reserved.
 *
 * The applied license is stored at the root directory of this package.
 */

namespace Union;


use Union\Entities\GroupEntity;
use Union\Exceptions\AlreadyExistsException;
use Union\Exceptions\IncompatibilityException;

class ConfigurationFactory
{
    /**
     * @var LoaderInterface[]
     */
    private $loader = [];

    /**
     * registers a set of class names as loaders to the factory
     *
     * @param \string[] ...$loaders
     * @throws AlreadyExistsException when the loader is already known
     * @throws \Exception when the loader is not compatible
     * @return ConfigurationFactory
     */
    public function register(string ... $loaders): ConfigurationFactory
    {
        foreach ( $loaders as $loader )
        {
            $loader = new $loader;
            $name = get_class($loader);

            if ( ! $loader instanceof LoaderInterface )
            {
                throw new \Exception('Unknown class: '.$name);
            }

            if ( array_key_exists($name, $this->loader) )
            {
                throw new AlreadyExistsException(
                    sprintf('class `%s` is already registered as a loader', $name)
                );
            }

            $this->loader[$name] = $loader;
        }

        return $this;
    }

    /**
     * registers a set of loader-instances to the factory
     *
     * @param LoaderInterface[] ...$loaders
     * @throws AlreadyExistsException when the loader is already known
     * @return $this
     */
    public function registerLoader(LoaderInterface ... $loaders)
    {
        foreach ( $loaders as $loader )
        {
            $name = get_class($loader);

            if ( array_key_exists($name, $this->loader) )
            {
                throw new AlreadyExistsException(
                    sprintf('class %s is already registered as a loader', $name)
                );
            }

            $this->loader[$name] = $loader;
        }

        return $this;
    }

    /**
     * loads a specific location ( file or directory ) into a new loader instance. directories are processed
     * recursively.
     *
     * @param \SplFileInfo $file
     * @param bool $immutable
     * @param bool $asGroup
     * @return ConfigurationInterface
     */
    public function load(\SplFileInfo $file, bool $immutable = false, $asGroup = false): ConfigurationInterface
    {
        if ( $file->isDir() ) {
            $extensions = $this->getSupportedExtensions();
            $directory = new \RecursiveDirectoryIterator($file->getRealPath());
            $recursion = new \RecursiveIteratorIterator($directory);
            $resources = new \CallbackFilterIterator($recursion, function(\SplFileInfo $file) use ($extensions) {
                return $file->isFile() && in_array($file->getExtension(), $extensions);
            });

            $stack = [];

            foreach ( $resources as $current ) {
                $stack[
                    $current->getBasename(sprintf('.%s', $current->getExtension()))
                ] = $this->{__FUNCTION__}($current, $immutable, true);
            }

            return $immutable
                ? new ImmutableConfiguration($stack)
                : new Configuration($stack)
            ;
        }

        $matches = array_filter($this->loader, function(LoaderInterface $loader) use ( $file ) {
            return $loader->match($file);
        });

        if ( empty($matches) ) {
            throw new IncompatibilityException(
                'Incompatible format or loader for file not registered'
            );
        }

        /**
         * @var LoaderInterface $loader
         */
        $loader = current($matches);

        if ( $asGroup ) {
            return new GroupEntity($loader->parse($file));
        }

        return $immutable
            ? new ImmutableConfiguration($loader->parse($file))
            : new Configuration($loader->parse($file))
        ;
    }

    /**
     * returns an array of supported extensions by the registered loaders for this factory
     *
     * @return array
     */
    public function getSupportedExtensions()
    {
        $grouped = array_map(function(LoaderInterface $loader) {
            return $loader->getSupportedExtensions();
        }, $this->loader);

        $stacked = call_user_func_array('array_merge', $grouped);

        return array_unique($stacked);
    }
}