<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function select2(Request $request)
    {
        $data = User::select('id', 'name', 'email')
            ->where(function ($query) use ($request) {
                $search_value = '%' . $request->search . '%';
                $query->where('name', 'like', $search_value)->orWhere('email', 'like', $search_value);
            })
            ->when($request->role, function ($query) use ($request) {
                $query->where('role', '=', $request->role);
            })
            ->where('is_actived', '=', '1')
            ->orderBy('name', 'asc')
            ->get();

        $res = [];
        foreach ($data as $item) {
            array_push($res, ['id' => Crypt::encryptString($item->id), 'text' => $item->name . " - " . $item->email]);
        }

        return $res;
    }

    // Select 2 Member
    public function search(Request $request)
    {
        $data = User::select('id', 'name', 'role')
            ->where('role', 'member')
            ->where('name', 'LIKE', '%' . $request->search . '%')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();

        foreach ($data as $index => $item) {
            $data[$index]['id'] = Crypt::encrypt($item['id']);
        }

        return json_encode($data);
    }
}
