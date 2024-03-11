<?php

namespace App\Http\Controllers;

use App\Events\DisplayPageEvent;
use App\Events\DisplayPingEvent;
use App\Events\DisplayPongEvent;
use App\Events\DisplayContentEvent;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function SendEvent()
    {
        event(new DisplayPageEvent);
    }

    public function DisplayPage()
    {
        $guid = $this->generateGUID();
        event(new DisplayPageEvent($guid));
        return view('display', ['guid' => $guid]);
    }

    public function Ping()
    {
        event(new DisplayPingEvent());
    }

    public function Pong($guid)
    {
        event(new DisplayPongEvent($guid));
    }

    public function DisplayContent($url,$type,$guid)
    {
        event(new DisplayContentEvent($url,$type,$guid));
    }
    // EXTRA CODE
    public function generateGUID()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
}
