<?php

namespace App\Http\Traits;

use App\Events\MatchNotification;
use App\Mail\SendMail;
use App\Models\Admin;
use App\Models\Configure;
use App\Models\EmailTemplate;
use App\Models\NotifyTemplate;
use App\Models\SiteNotification;
use App\Models\SmsControl;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use  Facades\App\Services\BasicCurl;

trait Notify
{

    public function sendMailSms($user, $templateKey, $params = [], $subject = null, $requestMessage = null)
    {
        $this->mail($user, $templateKey, $params, $subject, $requestMessage);
        $this->sms($user, $templateKey, $params, $requestMessage = null);
    }

    public function mail($user, $templateKey = null, $params = [], $subject = null, $requestMessage = null)
    {
        $basic = Configure::first();
        if ($basic->email_notification != 1) {
            return false;
        }
        $email_body = $basic->email_description;
        $templateObj = EmailTemplate::where('template_key', $templateKey)->where('language_id', $user->language_id)->where('mail_status', 1)->first();
        if (!$templateObj) {
            $templateObj = EmailTemplate::where('template_key', $templateKey)->where('mail_status', 1)->first();
        }
        $message = str_replace("[[name]]", $user->username, $email_body);

        if(!$templateObj && $subject == null){
           return false;
        }else{
            if ($templateObj) {
                $message = str_replace("[[message]]", $templateObj->template, $message);
                if (empty($message)) {
                    $message = $email_body;
                }
                foreach ($params as $code => $value) {
                    $message = str_replace('[[' . $code . ']]', $value, $message);
                }
            } else {
                $message = str_replace("[[message]]", $requestMessage, $message);
            }

            $subject = ($subject == null) ? $templateObj->subject : $subject;
            $email_from = ($templateObj) ? $templateObj->email_from : $basic->sender_email;

            @Mail::to($user)->queue(new SendMail($email_from, $subject, $message));
        }


    }



    public function mailVerification($user, $templateKey = null, $params = [], $subject = null, $requestMessage = null)
    {
        $basic = Configure::first();
        if ($basic->email_verification != 1) {
            return false;
        }
        $email_body = $basic->email_description;
        $templateObj = EmailTemplate::where('template_key', $templateKey)->where('language_id', $user->language_id)->where('mail_status', 1)->first();
        if (!$templateObj) {
            $templateObj = EmailTemplate::where('template_key', $templateKey)->where('mail_status', 1)->first();
        }
        $message = str_replace("[[name]]", $user->username, $email_body);

        if(!$templateObj && $subject == null){
            return false;
        }else{
            if ($templateObj) {
                $message = str_replace("[[message]]", $templateObj->template, $message);
                if (empty($message)) {
                    $message = $email_body;
                }
                foreach ($params as $code => $value) {
                    $message = str_replace('[[' . $code . ']]', $value, $message);
                }
            } else {
                $message = str_replace("[[message]]", $requestMessage, $message);
            }

            $subject = ($subject == null) ? $templateObj->subject : $subject;
            $email_from = ($templateObj) ? $templateObj->email_from : $basic->sender_email;

            @Mail::to($user)->send(new SendMail($email_from, $subject, $message));
        }

    }




    public function sms($user, $templateKey, $params = [], $requestMessage = null)
    {


        $basic = (object) config('basic');
        if ($basic->sms_notification != 1) {
            return false;
        }

        $smsControl =SmsControl::firstOrCreate(['id' => 1]);

        $templateObj = EmailTemplate::where('template_key', $templateKey)->where('language_id', $user->language_id)->where('sms_status', 1)->first();
        if (!$templateObj) {
            $templateObj = EmailTemplate::where('template_key', $templateKey)->where('sms_status', 1)->first();
        }

        if(!$templateObj && $requestMessage == null){
            return false;
        }else{
            if ($templateObj) {
                $template = $templateObj->sms_body;
                foreach ($params as $code => $value) {
                    $template = str_replace('[[' . $code . ']]', $value, $template);
                }
            } else {
                $template = $requestMessage;
            }
        }

        try{

            $paramData = is_null($smsControl->paramData) ? [] : json_decode($smsControl->paramData, true);
            $paramData = http_build_query($paramData);
            $actionUrl = $smsControl->actionUrl;
            $actionMethod = $smsControl->actionMethod;
            $formData = is_null($smsControl->formData) ? [] : json_decode($smsControl->formData, true);

            $headerData = is_null($smsControl->headerData) ? [] : json_decode($smsControl->headerData, true);
            if ($actionMethod == 'GET') {
                $actionUrl = $actionUrl . '?' . $paramData;
            }

            $formData = recursive_array_replace("[[receiver]]", $user->phone, recursive_array_replace("[[message]]", $template, $formData));
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $actionUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $actionMethod,
                CURLOPT_POSTFIELDS => http_build_query($formData),
                CURLOPT_HTTPHEADER => $headerData,
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
        }catch (\Exception $exception){

        }

    }


    public function userPushNotification($user, $templateKey, $params = [], $action = [])
    {
        $basic = (object) config('basic');
        if ($basic->push_notification != 1) {
            return false;
        }

        try {

            $templateObj = NotifyTemplate::where('template_key', $templateKey)->where('language_id', $user->language_id)->where('status', 1)->first();
            if (!$templateObj) {
                $templateObj = NotifyTemplate::where('template_key', $templateKey)->where('status', 1)->first();
            }
            if ($templateObj) {
                $template = $templateObj->body;
                foreach ($params as $code => $value) {
                    $template = str_replace('[[' . $code . ']]', $value, $template);
                }
                $action['text'] = $template;
            }
            $siteNotification = new SiteNotification();
            $siteNotification->description = $action;
            $user->siteNotificational()->save($siteNotification);
            event(new \App\Events\UserNotification($siteNotification, $user->id));
        }catch (\Exception $exception){

        }
    }


    public function adminPushNotification($templateKey, $params = [], $action = [])
    {

        $basic = (object) config('basic');
        if ($basic->push_notification != 1) {
            return false;
        }
        try {

            $templateObj = NotifyTemplate::where('template_key', $templateKey)->where('status', 1)->first();
            if(!$templateObj){
                return false;
            }

            if ($templateObj) {
                $template = $templateObj->body;
                foreach ($params as $code => $value) {
                    $template = str_replace('[[' . $code . ']]', $value, $template);
                }
                $action['text'] = $template;
            }

            $admins = Admin::all();
            foreach ($admins as $admin){
                $siteNotification = new SiteNotification();
                $siteNotification->description = $action;
                $admin->siteNotificational()->save($siteNotification);
                event(new \App\Events\AdminNotification($siteNotification, $admin->id));
            }
        }catch (\Exception $exception){

        }
    }


    /*
     * type Should Edit or
     */
    public function matchEvent($query, $type = 'Edit')
    {
        $throughEvent = [
            "id" => $query->id,
            "start_date" => $query->start_date,
            "end_date" => $query->end_date,
            "category_id" => $query->category_id,
            "tournament_id" => $query->tournament_id,
            "team1_id" => $query->team1_id,
            "team2_id" => $query->team1_id,
            "name" => $query->name,
            "name_slug" => slug($query->name),
            "slug" => slug(optional($query->gameTeam1)->name . ' vs ' . optional($query->gameTeam2)->name),
            'status' => $query->status,
            'team1' => optional($query->gameTeam1)->name,
            'team1_img' => getFile(config('location.team.path') . optional($query->gameTeam1)->image),
            'team2' => optional($query->gameTeam2)->name,
            'team2_img' => getFile(config('location.team.path') . optional($query->gameTeam2)->image),

            'game_category' => [
                'id' => optional($query->gameCategory)->id,
                'name' => optional($query->gameCategory)->name,
                'slug' => slug(optional($query->gameCategory)->name),
                'icon' => optional($query->gameCategory)->icon,
            ],
            'game_tournament' => [
                'id' => optional($query->gameTournament)->id,
                'name' => optional($query->gameTournament)->name,
                'slug' => slug(optional($query->gameTournament)->name)
            ],
            'totalQuestion' => count($query->activeQuestions),
            // Get Questions
            'questions' => $query->activeQuestions->where('end_time', '>', Carbon::now())->map(function ($question) use ($query) {
                return [
                    'id' => $question->id,
                    'name' => $question->name,
                    'limit' => $question->limit,
                    'end_time' => $question->end_time,
                    'is_unlock' => $question->is_unlock,
                    'status' => $question->status,
                    // Get Options
                    'options' => $question->activeGameOptions->map(function ($option) use ($question, $query) {
                        return [
                            'id' => $option->id,
                            'match_id' => $option->match_id,
                            'category_name' => optional($query->gameCategory)->name,
                            'category_icon' => optional($query->gameCategory)->icon,
                            "tournament_name" => optional($query->gameTournament)->name,
                            "match_name" => optional($query->gameTeam1)->name . ' vs ' . optional($query->gameTeam2)->name,
                            'question_id' => $option->question_id,
                            'question_name' => $question->name,
                            'option_name' => $option->option_name,
                            'ratio' => (float)$option->ratio,
                            'is_unlock_question' => $question->is_unlock,
                            'is_unlock_match' => $query->is_unlock,
                        ];
                    })
                ];
            })
        ];


        $throughEvent = (object) $throughEvent;

        if (config('basic.push_notification') == 1) {
            event(new MatchNotification($throughEvent, $type));
        }

    }




}
