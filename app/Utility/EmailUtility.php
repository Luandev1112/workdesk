<?php
/**
 * Created by PhpStorm.
 * User: Aunok
 * Date: 12/19/2019
 * Time: 4:37 PM
 */

namespace App\Utility;

use App\Mail\EmailManager;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;

class EmailUtility
{
    public static function send_email($subject, $content, $email, $link = "")
    {
        if (empty($email)) {
            return false;
        }

        $array['view'] = 'emails.template';
        $array['subject'] = $subject;
        $array['from'] = env('MAIL_USERNAME');
        $array['content'] = $content;
        $array['link'] = $link;

        try {
            Mail::to($email)->queue(new EmailManager($array));
        } catch (\Exception $e) {
            //dd($e->getMessage());
        }
    }
}
