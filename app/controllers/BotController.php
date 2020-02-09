<?php

class BotController
{
    public function actionBotWork ()
    {
        $data = json_decode ( file_get_contents ( 'php://input' ) );

        print_r($data);
        return '52503fa1';
    }
}