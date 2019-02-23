<?php

namespace App\Helpers;

use DB;
use File;

class Helper {
	public static function apiData($id = null, $params = []) {
        $path  = Base_path('storage/token.txt');
        $token = File::get($path);

        $_headers = [
                "Accept:application/json",
                "Authorization:$token"
            ];
        $url = 'https://api-billing-webservice.secu-ring.de/v1/invoices/debit/list';
        if (!is_null($id)) {
            $url = 'https://api-billing-webservice.secu-ring.de/v1/invoices/debit/list/'.$id;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $_headers);

        $response = curl_exec($ch);
        if (curl_error($ch)) {
            $error_msg = curl_error($ch);
        }

        if ($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
            return "cURL error ({$errno}):\n {$error_message}";
        }
        /*
         *  After receiving api data for faster performance (and if the data is not too large) we can store it in our side
         *	This time as we have a pagination we just keep the data as it is.
         */
        return $response;
	}	
}