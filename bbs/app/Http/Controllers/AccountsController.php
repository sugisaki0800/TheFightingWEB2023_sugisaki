<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Accounts;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $Accounts = Accounts::all();
        // var_dump($Accounts);
        return view('accounts.index');
    }

    public function login(Request $request) {
        // $email = $request->input('email');
        // $password = $request->input('password');

        // ログイン処理
        // ログイン成功したら、コメント一覧ページにリダイレクトする
        return redirect('/comments');
        return view('');
    }

    public function create_form()
    {
        return view('accounts.create');
    }

    public function create(Request $request)
    {
        //
        // $Account = Accounts::query()->create([
        //     'name' => $request['name'],
        //     'password' => Hash::make($request['password'])
        // ]);
        // Auth::login($Account);

        // return redirect()->web('profile');
        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'admin_flag' => 'integer | between:0,1'
        ]);

        // アカウント作成処理
        $admin_flag = $request->input('admin_flag');

        $AccountModel = new Accounts();
        $AccountModel->name = $request->input('name');
        $AccountModel->password = Hash::make($request->input('password'));
        $AccountModel->admin_flag = empty($admin_flag) ? 0 : $admin_flag;
        $AccountModel->save();

        // アカウント作成成功したら、ログインページにリダイレクトする
        return redirect('/accounts');
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
    public function show(Accounts $accounts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Accounts $accounts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Accounts $accounts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accounts $accounts)
    {
        //
    }

    public function profile()
   {
       return view('profile');
   }
}
