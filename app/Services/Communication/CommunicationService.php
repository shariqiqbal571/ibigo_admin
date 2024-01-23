<?php

namespace App\Services\Communication;

use App\Models\EmailTemplate;
use Exception;
use Illuminate\Support\Facades\Mail;

class CommunicationService
{

    public static function sendMail($slug, $data)
    {
        try {
            $template = EmailTemplate::where('title', $slug)->first();

            Mail::send([], [], function ($message) use ($template, $data) {
                $html_template = html_entity_decode($template->template);
                $name = isset($data['first_name']) ? $data['first_name'] . ' ' . $data['last_name'] : '';
                $message->to($data['email'], $name)
                    ->subject($template->subject)
                    ->setBody($template->parse($data, $html_template), 'text/html');
            });
        } catch (Exception $th) {
            return true;
        }
    }

}