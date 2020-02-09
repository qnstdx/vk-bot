<?php

class BotController
{
    public function actionBotWork ()
    {
        if ( ! empty ( $_POST ) )
        {
            return '52503fa1';
        } else {
            return 'noih';
        }

        return true;
    }
}