<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\UserModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $modules = Module::all();

        return response($modules->map->only(['id', 'name', 'description']), 200);
    }

    public function userModules(Request $request)
    {
        $modules = Module::all();

        foreach ($modules as $module) {
            $state = UserModule::where([['user_id', Auth::id()], ['module_id', $module->id]])->first();
            if ($state && $state->active === 1) {
                $module->active = true;
            } else {
                $module->active = false;
            }
        }

        return response($modules->map->only(['id', 'name', 'description', 'active']), 200);
    }

    public function activate(Request $request, int $id)
    {
        $module = Module::where('id', $id)->first();

        if (!$module) {
            return response(['message' => 'Module not fount'], 404);
        }

        $user_module = UserModule::where([['user_id', Auth::id()], ['module_id', $id]])->first();

        if (!$user_module) {
            $user_module = UserModule::create(
                [
                    'user_id' => Auth::id(),
                    'module_id' => $module->id
                ]
            );
        }

        $user_module->update([
            'active' => true
        ]);

        return response(['message' => 'Module activated'], 200);
    }

    public function deactivate(Request $request, int $id)
    {
        $module = Module::where('id', $id)->first();

        if (!$module) {
            return response(['message' => 'Module not fount'], 404);
        }

        $user_module = UserModule::where([['user_id', Auth::id()], ['module_id', $id]])->first();

        if (!$user_module) {
            $user_module = UserModule::create(
                [
                    'user_id' => Auth::id(),
                    'module_id' => $module->id
                ]
            );
        }

        $user_module->update([
            'active' => false
        ]);

        return response(['message' => 'Module deactivated'], 200);
    }
}
