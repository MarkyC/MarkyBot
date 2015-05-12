<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 2015-03-14
 * Time: 12:09 AM
 */

class LoveHandler implements IHandler {
    private $LOVES = [
        "I love you too %s"
        , "My milkshake brings ALL the boys to the yard, %s"
        , "All my bitches love me, %s"
        , "%s, I love all my children"
    ];

    const MARKYBOT_LOVE = "markybot I love you";

    public function handle($input) {

        // We're set to off right now, do nothing:
        if ( !is_active() ) { return; }

        // no text message posted, do nothing...
        if ( !isset($input->text) || !isset($input->name) ) { return; }

        if (($index = stripos($input->text, self::MARKYBOT_LOVE)) !== FALSE) {
            send($this->love($input->name));
        }

    }

    function love($name) {
        return sprintf($this->LOVES[mt_rand(0, count($this->LOVES) - 1)], $name);
    }
}