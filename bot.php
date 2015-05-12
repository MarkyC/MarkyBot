<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 2015-03-13
 * Time: 9:19 PM
 */

// Log Errors to a file
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set("log_errors", 1);
ini_set("error_log", "errors.log");

// Composer's autoloader loads our dependencies
require 'vendor/autoload.php';
require 'vendor/zzbomb/groupme/src/groupme.php';
require 'handlers/IHandler.php';
require 'handlers/StateHandler.php';
require 'handlers/SwearHandler.php';
require 'handlers/ChirpHandler.php';
require 'handlers/LoveHandler.php';
require 'handlers/ReminderHandler.php';

// sets GROUPME_TOKEN, GROUP_ID, and BOT_ID, not in VCS for obvious reasons ;)
require 'config.php';


// grab the input that was sent to us from
// make sure the callback URL of the bot points to this file!
$input = json_decode(@file_get_contents('php://input'));

// Do nothing if we were not provided any input or the message was empty
if ( empty($input) ) {
    error_log("No input provided\n");
    return;
}

// This bot posted it, ignore
if ("bot" == $input->sender_type) {
    return;
}

// StateHandler bypasses all sorts of shit
$stateHandler = new StateHandler();
$stateHandler->handle($input);

// If we've posted in the last 2 seconds, chill
if ( (time() - @file_get_contents("last_accessed")) <= 2 ) {
    return;
} else {
    // Update last accessed if we're going to continue
    @file_put_contents("last_accessed", time());
}

$handlers = [new SwearHandler(), new ChirpHandler(), new ReminderHandler(), new LoveHandler()];
foreach ( $handlers as $h ) {
    if ($h instanceof IHandler) {
        $h->handle($input);
    }
}

// refactor below this

/**
 * @return bool TRUE if we're ON (live), FALSE if we're OFF
 */
function is_active() {
    return @file_get_contents("state") === "ON";
}

function send($message) {
    $gm = new groupme(GROUPME_TOKEN);
    $gm->bots->post(array('bot_id' => BOT_ID, 'text' => $message));
}

/**
 * @return string   a GUID suitable for a message
 */
function create_guid() {
    return sprintf('%04X%04X%04X%04X',
        mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535));
}