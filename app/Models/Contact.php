<?php

namespace App\Models;

use App\Helpers\Helper;
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


    private static function filter($params)
    {
        $contact = new Contact();

        if (isset($params['keyword'])) {
            $keyword = addslashes($params['keyword']);
            if ($keyword != 0 || $keyword != null) {
                $contact = $contact->where('users.name', 'like', "%$keyword%")
                    ->orWhere('users.email', 'like', "%$keyword%")
                    ->orWhere('users.phone', 'like', "%$keyword%");
            }
        }

        if (isset($params['created_at'])) {
            $publishDate = $params['created_at'];
            if ($publishDate != 0) {
                $publishDate = str_replace('+', ' ', $publishDate);
                $publishDate = explode(' - ', $publishDate);
                $contact = $contact->whereRaw("contacts.created_at BETWEEN ? AND ?", [date('Y/m', strtotime($publishDate[0])), date('Y/m', strtotime("+1 day", strtotime($publishDate[1])))]);
            }
        }

        return $contact;
    }

    public static function createContact($request)
    {
        $user = Auth::user();
        $request['user_id'] = $user->id;
        $request['type'] = CUSTOMER_SEND;

        return self::create($request);
    }

    public static function repContact($request)
    {
        $request['type'] = ADMIN_SEND;

        return self::create($request);
    }

    public static function getContactOfUser($userId)
    {
        $user = Auth::user();

        $contacts = self::whereNull('contacts.deleted_at')
                ->selectRaw('contacts.user_id, contacts.message, contacts.type, contacts.created_at, users.name')
                ->where('contacts.user_id', $userId)
                ->join('users', 'users.id', '=', 'contacts.user_id')
                ->get();

        return $contacts;
    }

    public static function getDistinct($params = null)
    {
        $contact = self::filter($params);

        $order = Helper::getSortParam($params);
        if ($order == '1 = 1') {
            $order = "contacts.user_id DESC ";
        }

        $contact = $contact->selectRaw("DISTINCT(contacts.user_id) as user_id, users.name, users.email, users.phone")
            ->join('users', 'users.id', '=', 'contacts.user_id')
            ->distinct()
            ->orderByRaw($order)
            ->paginate(LIMIT);

        return $contact;
    }
}
