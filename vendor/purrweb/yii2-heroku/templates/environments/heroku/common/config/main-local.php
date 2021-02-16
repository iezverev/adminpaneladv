<?php



return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=d6rii63wp64rsfb5.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=u14mvoezhziflrgo',
            'username' => 'sulcjgnwow4klh4i',
            'password' => 'eba9qaezm15bkndg',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
