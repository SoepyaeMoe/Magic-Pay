<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminUser;
use App\Http\Requests\UpdateAdminUser;
use App\Models\AdminUser;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;

class AdminUserController extends Controller
{
    public function index()
    {
        $data['data'] = AdminUser::get();
        return view('backend.admin_user.index', $data);
    }
    public function create()
    {
        return view('backend.admin_user.create');
    }
    public function store(StoreAdminUser $request)
    {
        $user = new AdminUser;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('admin.admin-user.index')->with('create', 'Successfully Created');
    }
    public function edit($id)
    {
        $data['user'] = AdminUser::findOrFail($id);
        return view('backend.admin_user.edit', $data);
    }
    public function update(UpdateAdminUser $request, $id)
    {
        $user = AdminUser::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password ? Hash::make($request->password) : $user->password;
        $user->update();
        return redirect()->route('admin.admin-user.index')->with('create', 'Successfully Updated');
    }
    public function show()
    {
        dd('show');
    }
    public function destroy($id)
    {
        $user = AdminUser::findOrFail($id);
        $user->delete();
        return 'success';
    }
    public function ssd()
    {
        $users = AdminUser::query();
        return DataTables::of($users)
            ->editColumn('updated_at', function ($each) {
                return $each->updated_at ? $each->updated_at->format('d/m/Y H:i:s') : '-';
            })
            ->editColumn('created_at', function ($each) {
                return $each->created_at ? $each->created_at->format('d/m/Y H:i:s') : '-';
            })
            ->editColumn('user_agent', function ($each) {
                if ($each->user_agent) {
                    $agent = new Agent();
                    $agent->setUserAgent($each->user_agent);
                    $device = $agent->device();
                    $platform = $agent->platform();
                    $browser = $agent->browser();
                    return $device . '|' . $platform . '|' . $browser;

                } else {
                    return '-';
                }
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href="' . route('admin.admin-user.edit', $each->id) . '" class="text-primary me-2"><i class="fas fa-user-edit"></i></a>';
                $delete_icon = '<a href="#" class="text-danger delete" data-id="' . $each->id . '"><i class="fas fa-trash-alt"></i></a>';
                return '<div class="action_icons">' . $edit_icon . $delete_icon . '</div>';
            })
            ->toJson();
    }
}
