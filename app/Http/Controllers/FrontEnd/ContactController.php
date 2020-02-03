<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class ContactController extends FrontEndController
{
    public function sendContact(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();

        DB::beginTransaction();
        if (Contact::createContact($input)) {
            $contacts = Contact::getContactOfUser($user->id);
            $content = view('frontend.pages._chat_content', compact('contacts'))->render();

            DB::commit();
            return response()->json(true);
        } else {
            DB::rollBack();
        }
    }

    public function getContact()
    {
        $user = Auth::user();
        $contacts = Contact::getContactOfUser($user->id);
        $content = view('frontend.pages._chat_content', compact('contacts'))->render();

        return response()->json(['content' => $content, 'countItem' => count($contacts)]);
    }
}
