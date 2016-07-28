<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=manosenelcodigo',
    'username' => 'pruebas',
    'password' => '123456',
    'charset' => 'utf8',
    'on afterOpen'  => function($event) {
        $event->sender->createCommand("SET time_zone = '-5:00'")->execute();
    }
];
