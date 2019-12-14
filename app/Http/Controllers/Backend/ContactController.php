<?php

namespace App\Http\Controllers\Backend;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params = \request()->all();
        $contacts = Contact::getDistinct($params);

        return view('backend.pages.contact.index', compact('contacts'));
    }

    public function detail(Request $request)
    {
        if ($request->ajax()) {
            $userId = $request->get('user_id');
            $contacts = Contact::getContactOfUser($userId);

            $contact = view('backend.pages.contact._contact', compact('contacts'))->render();

            return response()->json(['contact' => $contact, 'countItem' => count($contacts)], 200);
        }
    }

    public function reply(Request $request)
    {
        $input = $request->all();

        DB::beginTransaction();
        if (Contact::repContact($input)) {

            DB::commit();
            return response()->json(true);
        } else {
            DB::rollBack();
        }
    }
}
