<?php

namespace BecklynSymfony;

use Composer\IO\IOInterface;
use Composer\Script\Event;


/**
 * Handles the integration on initial installation via composer.
 */
class Composer
{
    /**
     * Main entry point for updates after the root package was installed
     *
     * @param Event $event
     */
    public static function hookRootPackageInstall (Event $event)
    {
        $io                = $event->getIO();
        $configuredAppPath = self::getConfiguredAppPath($event);

        $io->write([
            "",
            "",
            "  <fg=magenta>Preparing your Becklyn Symfony Edition (╯°□°）╯︵ ┻━┻﻿</fg=magenta>",
            "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~",
            "",
        ]
        );

        $projectName = self::getProjectName($io);

        $io->write("");
        self::updateMainConfig($io, $projectName, $configuredAppPath);

        $io->write([
            "",
            "<fg=green>Everything installed successfully.</fg=green>",
            "<fg=green>Have fun using Symfony!</fg=green>",
            "<fg=green>┬─┬ノ( º _ ºノ)﻿</fg=green>"
        ]);
    }



    /**
     * Asks for the project name
     *
     * @param IOInterface $io
     *
     * @return string
     */
    private static function getProjectName (IOInterface $io)
    {
        $io->write([
            "<fg=cyan>Project name</fg=cyan>",
            "You need to set a project name before using the application.",
            "The project name can not be empty, must contain a letter, may only contain lower case letters (a-z) and underscores.",
            "",
        ]);

        return $io->askAndValidate("Project name: ", [self::class, "isValidPackageName"]);
    }



    /**
     * Update the main config
     *
     * @param IOInterface $io
     * @param string      $projectName
     * @param string      $configuredAppPath
     */
    private static function updateMainConfig (IOInterface $io, $projectName, $configuredAppPath)
    {
        $replacements = [
            "#> session_name <#" => $projectName . "_session",
            "#> project_name <#" => $projectName,
        ];

        $io->write([
            "<fg=cyan>Updating the main configuration</fg=cyan>",
            "The installer is now updating your main configuration according to your project name.",
            "You can change everything later by manually editing <fg=yellow>{$configuredAppPath}/config/config.yml</fg=yellow>.",
            "",
            "The following settings are updated:",
            "-> <fg=yellow>framework.session.name</fg=yellow>: {$replacements['#> session_name <#']}",
            "-> <fg=yellow>monolog.handlers.swift</fg=yellow> (prod): Plus address and mail subject to: {$replacements['#> project_name <#']}",
        ]);

        self::replaceInAppFile("config/config.yml", $replacements);
        self::replaceInAppFile("config/config_prod.yml", $replacements);
    }



    /**
     * Returns the path to the app dir
     *
     * @return string
     */
    private static function getAppDirPath ()
    {
        return dirname(__DIR__);
    }



    /**
     * Validates the given package name
     *
     * @param string $packageName
     *
     * @return string the validated package name
     * @throws \InvalidArgumentException if the given package name is invalid
     */
    public static function isValidPackageName ($packageName)
    {
        // check whether there is at least one letter
        if (0 === preg_match("/[a-z]/", $packageName))
        {
            throw new \InvalidArgumentException("The package name must contain at least one letter.");
        }

        // check that there are only underscores and lower case letters
        if (1 === preg_match("/\\A[_a-z0-9]+\\Z/", $packageName))
        {
            return $packageName;
        }

        throw new \InvalidArgumentException("The package name may only contain lower case letters (a-z) and underscores.");
    }



    /**
     * Replace something in an app dir file
     *
     * @param string $path
     * @param array  $replaces
     */
    private static function replaceInAppFile ($path, array $replaces)
    {
        $path     = ltrim($path, "/");
        $filePath = self::getAppDirPath() . "/{$path}";
        $content  = file_get_contents($filePath);
        $content  = str_replace(array_keys($replaces), array_values($replaces), $content);
        file_put_contents($filePath, $content);
    }



    /**
     * Returns the symfony app path as configured in composer
     *
     * @param Event $event
     *
     * @return string
     */
    private static function getConfiguredAppPath (Event $event)
    {
        $extra = $event->getComposer()->getPackage()->getExtra();

        return (is_array($extra) && isset($extra["symfony-app-dir"]))
            ? rtrim($extra["symfony-app-dir"], "/")
            : "app";
    }
}
