<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\UUIDGenerate;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('backend.user.index', compact('users'));
    }
    public function create()
    {
        return view('backend.user.create');
    }
    public function store(StoreUser $request)
    {
        DB::beginTransaction();
        try {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();

            Wallet::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'account_number' => UUIDGenerate::generateNumber(),
                    'amount' => 0,

                ]
            );
            DB::commit();
            return redirect()->route('admin.user.index')->with('create', 'Successfully Created.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['fail' => 'Something Wrong.'])->withInput();
        }
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.user.edit', compact('user'));
    }
    public function update(UpdateUser $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password ? $request->password : $user->password;
        $user->save();
        return redirect()->route('admin.user.index')->with('create', 'Successfully Updated');
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $wallet = Wallet::where('user_id', $id)->first();
        $user->delete();
        $wallet->delete();
        return 'stop';
    }
    public function ssd()
    {
        $user = User::query();
        return DataTables::of($user)
            ->editColumn('created_at', function ($each) {
                return $each->created_at ? $each->created_at->format('d/m/Y H:i:s') : '-';
            })
            ->editColumn('updated_at', function ($each) {
                return $each->updated_at ? $each->updated_at->format('d/m/Y H:i:s') : '-';
            })
            ->editColumn('login_at', function ($each) {
                return $each->login_at ? Carbon::parse($each->login_at)->format('d/m/Y H:i:s') : '-';
            })
            ->editColumn('user_agent', function ($each) {
                $agent = new Agent();
                $device = $agent->device();
                $platform = $agent->platform();
                $browser = $agent->browser();
                return $device . '|' . $platform . '|' . $browser;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href="' . route('admin.user.edit', $each->id) . '" class="text-primary"><i class="fas fa-user-edit me-2"></i></a>';
                $delete_icon = '<a href="#" class="text-danger delete" data-id = ' . $each->id . '><i class="fas fa-trash-alt"></i></a>';
                return '<div class="action_icons">' . $edit_icon . $delete_icon . '</div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
