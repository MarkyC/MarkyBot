<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 2015-03-14
 * Time: 12:09 AM
 */

class ReminderHandler implements IHandler {

    const MARKYBOT_REMIND_ME = "markybot remind me";

    private $valid_dates = [
        "today"
        , "tomorrow"
        , "monday"
        , "tuesday"
        , "wednesday"
        , "thursday"
        , "friday"
        , "saturday"
        , "sunday"
    ];

    public function handle($input) {

        // We're set to off right now, do nothing:
        if ( !is_active() ) { return; }

        // no text message posted, do nothing...
        if ( !isset($input->text) ) { return; }

        // not a reminder, do nothing
        if (!$this->startsWithInsensitive($input->text, self::MARKYBOT_REMIND_ME)) { return; }

        // trim the "markybot remind me" from the command, and any leading/trailing whitespace
        $reminder = trim(substr($input->text, strlen(self::MARKYBOT_REMIND_ME)));

        // Try to get the date they want to be reminded
        // ie: markybot remind me {today} at ...
        $reminderDate = $this->getReminderDateTime(trim($reminder));

        // Couldn't parse a date, do nothing
        if ($reminderDate === FALSE) {
            send("Sorry, I don't understand what time you want me to remind you");
            return;
        }

        // If they specified the past, remind them 30s in the future
        if ($reminderDate < new DateTime('now', new DateTimeZone("America/Toronto"))) {
            send("That was in the past, I'll remind you in 30 secs");
            $reminderDate = new DateTime('now', new DateTimeZone("America/Toronto"));
            $reminderDate->setTimestamp(time() + 30);
        }

        $reminderText = trim(substr($reminder, strpos($reminder, "to")));

        send(sprintf("Sure thing %s, I will remind you to %s at %s",
            $input->name, $reminderText, $reminderDate->format(DATE_RFC850)));

        // Sleep until the user's specified time
        time_sleep_until($reminderDate->getTimestamp());

        send(sprintf("hey %s, it's %s. You wanted me to remind you to %s",
            $input->name, $reminderDate->format(DATE_RFC850), $reminderText));
    }

    function getReminderDateTime($reminder) {

        // markybot remind me {time-here} to {reminder-here}
        // we want just {time-here}
        if (($position = strpos($reminder, "to ")) !== FALSE ) {

            // reminder should now look like {today|monday} {7:00pm|midnight}
            $reminderDateTime = strtolower(trim(substr($reminder, 0, $position)));

            return date_create($reminderDateTime, new DateTimeZone("America/Toronto"));
        }

        return FALSE;
    }

    function startsWith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    function startsWithInsensitive($haystack, $needle) {
        return $this->startsWith(strtolower($haystack), strtolower($needle));
    }

    function startsWithAnyInsensitive($haystack, $array) {
        foreach ($array as $needle) {
            if ($this->startsWithInsensitive($haystack, $needle)) {
                // return the needle it started with
                return $needle;
            }
        }
        // If we're here, it doesn't start with anything from the array
        return FALSE;
    }
}