<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 2015-03-13
 * Time: 11:56 PM
 */

class StateHandler implements IHandler {

    private $commands = <<<TEXT

Here are my commands:

MarkyBot ON - turns me on ;)

MarkyBot OFF - turns me off

MarkyBot CHIRP {name} - Chirps {name}

MarkyBot I love you - Loves you right back ;)

MarkyBot remind me (today|Wednesday) (4:00pm|midnight) to {reminder} - reminds you to do shit at that time
TEXT;


    public function handle($input) {

        // no text message posted, do nothing...
        if (!isset($input->text)) {
            return;
        }

        if (preg_match("/markybot off/", strtolower($input->text)) ||
            preg_match("/shut up markybot/", strtolower($input->text))
        ) {
            send("Okay, I'll shut my bitch ass up.");
            @file_put_contents("state", "OFF");
            exit;
        } else if (preg_match("/markybot on/", strtolower($input->text))) {
            send("I'm back niggas!".$this->commands);
            @file_put_contents("state", "ON");
        }
    }
}
