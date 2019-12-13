<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = ['user_id', 'message', 'type'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function createContact($request)
    {
        $user = Auth::user();
        $request['user_id'] = $user->id;
        $request['type'] = CUSTOMER_SEND;

        return self::create($request);
    }

    public static function getContactOfUser()
    {
        $user = Auth::user();

        $contacts = self::whereNull('contacts.deleted_at')
                ->where('contacts.user_id', $user->id)
                ->select('contacts.user_id', 'contacts.message', 'contacts.type', 'contacts.created_at')
                ->get();

        return $contacts;
    }
}
