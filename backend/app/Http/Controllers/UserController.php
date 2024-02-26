<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Post;
use Yajra\DataTables\Facades\Datatables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::select('*');

            if ($request->has('search.value')) {
                $searchValue = $request->input('search.value');
                $query->where(function ($q) use ($searchValue) {
                    $q->where('name', 'like', "%$searchValue%")
                      ->orWhere('nick_name', 'like', "%$searchValue%")
                      ->orWhere('email', 'like', "%$searchValue%")
                      ->orWhere('phone_number', 'like', "%$searchValue%")
                      ->orWhere('gender', 'like', "%$searchValue%")
                      ->orWhere('birthday', 'like', "%$searchValue%")
                      ->orWhere('last_logined_at', 'like', "%$searchValue%");
                });
            }

            if ($request->has('order')) {
                $orderColumn = $request->input('order.0.column');
                $orderDirection = $request->input('order.0.dir');
                $query->orderBy($request->input("columns.$orderColumn.name"), $orderDirection);
            }

            $users = $query->paginate($request->input('length'));
    
            $data = [];
            foreach ($users as $user) {
                $data[] = [
                    'id' => $user->id,
                    'avatar' => $user->avatar,
                    'name' => $user->name,
                    'nick_name' => $user->nick_name,
                    'gender' => $user->gender,
                    'birthday' => $user->birthday,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'last_logined_at' => $user->last_logined_at,
                    'detail_link' => '<a href="'.route('users.show', $user->id).'" class="text-info">詳細を見る</a>',
                    'action' => '<a href="javascript:;" class="text-primary"><i class="ti ti-trash"></i></a>',
                ];
            }
    
            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => User::count(),
                'recordsFiltered' => $users->total(),
                'data' => $data,
            ]);
        }
    
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(10)->get();

        return view('users.show', compact('user', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
