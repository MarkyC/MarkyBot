<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 2015-03-14
 * Time: 12:09 AM
 */

class SwearHandler implements IHandler {

    private $BAD_WORDS = [
        "slut"
        , "bitch"
        //, "hoe"
        , "whore"
        //, "ho"
    ];

    public function handle($input) {

        // We're set to off right now, do nothing:
        if ( !is_active() ) { return; }

        // no text message posted, do nothing...
        if ( !isset($input->text) ) { return; }

        foreach ($this->BAD_WORDS as $word) {
            if ( FALSE !== strpos(strtolower($input->text), $word) ) {
                send("that fuckin $word...");
                return;
            }
        }
    }
}