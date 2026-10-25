<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
 
class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }
 
    public function create()
    {
        return view('users.create');
    }
 
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,NULL,id,tenant_id,' . auth()->user()->tenant_id,
            'password' => 'required|string|min:8|confirmed',
            'is_financeiro' => 'nullable|boolean',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tenant_id' => auth()->user()->tenant_id,
            'is_financeiro' => $request->boolean('is_financeiro'),
        ]);
 
        return redirect()->route('users.index', ['tenant' => request()->route('tenant')])->with('success', 'Usuário criado com sucesso.');
    }
 
    public function edit()
    {
        $user = User::findOrFail(request()->route('user'));
        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(request()->route('user'));
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id . ',id,tenant_id,' . auth()->user()->tenant_id,
            'password' => 'nullable|string|min:8|confirmed',
            'is_financeiro' => 'nullable|boolean',
        ]);
 
        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_financeiro = $request->boolean('is_financeiro');
 
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
 
        $user->save();
 
        return redirect()->route('users.index', ['tenant' => request()->route('tenant')])->with('success', 'Usuário atualizado com sucesso.');
    }
 
    public function destroy()
    {
        $user = User::findOrFail(request()->route('user'));
        if (User::count() <= 1) {
            return redirect()->route('users.index', ['tenant' => request()->route('tenant')])->with('error', 'Não é possível excluir o único usuário do sistema.');
        }
 
        $user->delete();
        return redirect()->route('users.index', ['tenant' => request()->route('tenant')])->with('success', 'Usuário excluído com sucesso.');
    }
}
