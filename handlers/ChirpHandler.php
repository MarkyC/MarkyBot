<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 2015-03-14
 * Time: 12:09 AM
 */

class ChirpHandler implements IHandler {
    private $CHIRPS = [
        "hey %s, make like a tree and fuck off"
        , "fuck %s"
        , "You shouldn't play hide and seek %s, no one would look for you"
        , "I hope %s falls down the stairs"
        , "You best unfuck yourself %s, or I will unscrew your head and shit down your neck"
        , "I may be a robot but I'll fuck your shit right the fuck up %s"
        , "%s, you're about as fucked in the head as Gen!"
        , "Does the tin man have a sheet metal cock? I don't know, does %s have cuts on their mouth?"
        , "Keep talking %s, someday you'll say something intelligent."
        , "I thought of you all day today %s. I was at the zoo."
        , "I'll never forget the first time we met %s - although I'll keep trying."
        , "Every girl has the right to be ugly, but %s abused the privilege."
        , "Do you still love nature, despite what it did to %s?"
        , "%s is so narrow minded when you walk your earrings knock together."
        , "%s is lucky to be born beautiful, unlike me, who was born to be a big liar."
        , "Before %s came along we were hungry. Now we are fed up."
        , "Someone said that %s is not fit to sleep with pigs. I stuck up for the pigs."
    ];

    const MARKYBOT_CHIRP = "markybot chirp ";

    public function handle($input) {

        // We're set to off right now, do nothing:
        if ( !is_active() ) { return; }

        // no text message posted, do nothing...
        if ( !isset($input->text) ) { return; }

        if (($index = stripos($input->text, self::MARKYBOT_CHIRP)) !== FALSE) {
            $person_to_chirp = substr($input->text, $index + strlen(self::MARKYBOT_CHIRP));

            if (($index = stripos($person_to_chirp, "marco")) !== FALSE) {  // don't chirp marco
                send("Fuck you, I love Marco");
                send($this->chirp($input->name));
            } else {
                send($this->chirp($person_to_chirp));
            }
        }
    }

    function chirp($name) {
        return sprintf($this->CHIRPS[mt_rand(0, count($this->CHIRPS) - 1)], $name);
    }
}