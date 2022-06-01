<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit383772976b4e2d49d41d2cfe67921eef
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

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit383772976b4e2d49d41d2cfe67921eef::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit383772976b4e2d49d41d2cfe67921eef::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
