<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberConfirmInviteRequest;
use App\Http\Requests\MemberInviteRequest;
use App\Models\User;
use App\Notifications\UserInviteNotification;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $members = User::where('parent_user_id', auth()->id())->get();

        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MemberInviteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MemberInviteRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => 'password',
            'parent_user_id' => auth()->id(),
            'invitation_token' => Str::random(32),
        ]);

        $user->notify(new UserInviteNotification());

        return redirect()->route('members.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::where('parent_user_id', auth()->id())->where('id', $id)->firstOrFail();
        $user->delete();

        return redirect()->route('members.index');
    }

    /**
     * @param string $invitation_token
     * @return Application|Factory|View
     */
    public function invitation(string $invitation_token)
    {
        $user = User::where('invitation_token', $invitation_token)->firstOrFail();

        return view('auth.invitation', compact('user'));
    }


    /**
     * @param MemberConfirmInviteRequest $request
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function confirmInvitation(MemberConfirmInviteRequest $request)
    {
        $user = User::where('invitation_token', $request->input('invitation_token'))->firstOrFail();

        $user->update([
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
            'invitation_token' => null,
        ]);

        auth()->loginUsingId($user->id);

        return redirect('/');
    }
}
