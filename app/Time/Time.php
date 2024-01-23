<?php 

namespace App\Time;

use Carbon\Carbon;

class Time{
    public function timePrevious($current) {
        $time = now();
        // echo date('Y-m-d H:i:s',strtotime($time));
        // exit();
        $time = strtotime($time);
        $previous = $time - $current;
        
        if ($previous < 0) {
            $previous = date('s',strtotime($previous)) . ' seconds';
        }
        else if($previous < 60)
        {
            if($previous > 1)
            {
                $previous = $previous . ' seconds';
            }
            else{
                $previous = $previous . ' second';
            }
        }
        else if($previous < 3600 && $previous > 60)
        {
            if(floor($previous / 60) > 1)
            {
                $previous = floor($previous / 60)  . ' minutes';
            }
            else{
                $previous = floor($previous / 60)  . ' minute';
            }
        }
        else if($previous < 86400 && $previous > 3600)
        {
            if(floor($previous / 3600) > 1)
            {
                $previous = floor($previous / 3600)  . ' hours';
            }
            else{
                $previous = floor($previous / 3600)  . ' hour';
            }
        }
        else if($previous < 604800 && $previous > 86400)
        {
            if(floor($previous / 86400) > 1)
            {
                $previous = floor($previous / 86400) . ' days';
            }
            else{
                $previous = floor($previous / 86400) . ' day';
            }
        }
        else if($previous < 2592000 && $previous > 604800)
        {
            if(floor($previous / 604800) > 1)
            {
                $previous = floor($previous / 604800)  . ' weeks';
            }
            else{
                $previous = floor($previous / 604800)  . ' week';
            }
        }
        else if($previous < 31536000 && $previous > 2592000)
        {
            if(floor($previous / 2592000) > 1)
            {
                $previous = floor($previous / 2592000) . ' months';
            }
            else{
                $previous = floor($previous / 2592000) . ' month';
            }
        }
        else if($previous > 31536000 && $previous < 2592000)
        {
            if(floor($previous / 31536000) > 1)
            {
                $previous = floor($previous / 31536000) . ' years';
            }
            else{
                $previous = floor($previous / 31536000) . ' year';
            }
        }
        else{
            $previous = 'Many years';
        }

        return $previous;
    }
}