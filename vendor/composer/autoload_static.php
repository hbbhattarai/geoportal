<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit021f29e023427e309af7e0dbbb1a9bf8
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit021f29e023427e309af7e0dbbb1a9bf8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit021f29e023427e309af7e0dbbb1a9bf8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit021f29e023427e309af7e0dbbb1a9bf8::$classMap;

        }, null, ClassLoader::class);
    }
}