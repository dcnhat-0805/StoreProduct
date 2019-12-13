<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function sendContact(Request $request)
    {
        $input = $request->all();

        DB::beginTransaction();
        if (Contact::createContact($input)) {
            $contacts = Contact::getContactOfUser();
            $content = view('frontend.pages._chat_content', compact('contacts'))->render();

            DB::commit();
            return response()->json(true);
        } else {
            DB::rollBack();
        }
    }

    public function getContact()
    {
        $contacts = Contact::getContactOfUser();
        $content = view('frontend.pages._chat_content', compact('contacts'))->render();

        return response()->json($content);
    }
}
