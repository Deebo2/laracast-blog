<?php

namespace App\Http\Controllers;

use App\Services\Newsletter;
use MailchimpMarketing\ApiException;

class NewsletterController extends Controller
{
   public function __invoke(Newsletter $newsletter){
        request()->validate([
            'email' => 'required|email'
        ]);
        try {
        $newsletter->subscribe(request('email'));
        return redirect('/')->with('success','Yow are now signed up for our newsletter');
        } catch (ApiException $e) {
        echo $e->getMessage();
        }
   }
}
