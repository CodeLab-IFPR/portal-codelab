<?php

namespace App\Http\Controllers\Auth;

use App\Mail\SendPasswordMail;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Providers\ImageUploader;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Queue;
use App\Jobs\SendPasswordJob;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'cargo' => 'nullable|min:5|max:100',
            'cpf' => 'required|unique:users,cpf',
            'biografia' => 'nullable|min:10',
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
            'alt' => 'nullable|min:5|max:255',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        ]);
    
        $entrada = $request->all();
        $entrada['ativo'] = $request->has('ativo') ? $request->ativo : false;
        $password = $request->input('generated_password');
        $entrada['password'] = Hash::make($password);
        $entrada['imagem'] = $request->has('cropped_image') && $request->cropped_image ? $entrada['imagem'] : 'default.png';
    
        if ($request->has('cropped_image') && $request->cropped_image) {
            $image_parts = explode(";base64,", $request->cropped_image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = uniqid() . '.png';
            $imageFullPath = sys_get_temp_dir() . '/' . $imageName;
            file_put_contents($imageFullPath, $image_base64);
    
            $uploader = new ImageUploader();
            $uploader->setCompression(30);
            $uploader->setResolution(160);
            $uploader->setDestinationPath('users/');
            $entrada['imagem'] = $uploader->upload(new \Illuminate\Http\File($imageFullPath));
        }
    
        $user = User::create($entrada);
    
        // Enviar email de forma assíncrona usando um job
        SendPasswordJob::dispatch($user, $password);
    
        return redirect()->route("users.index")
            ->with("success", "Usuário criado com sucesso.");
    }

    public function index(Request $request)
    {
        $usersQuery = User::latest();
    
        if ($request->search) {
            $usersQuery->where(function (Builder $builder) use ($request) {
                $builder->where('name', 'like', "%{$request->search}%")
                        ->orWhere('cpf', 'like', "%{$request->search}%")
                        ->orWhere('cargo', 'like', "%{$request->search}%");
            });
        }
    
        $users = $usersQuery->paginate(5);
    
        if ($request->ajax()) {
            return response()->json([
                'table' => view('users.table', compact('users'))->render()
            ]);
        }
    
        return view('users.index', compact('users'));
    }

    public function about(): View
    {
        $users = User::where('ativo', true)->get();
        
        return view('about', compact('users'));
    }

    public function show(User $user): View
    {
        return view("users.show", compact("user"));
    }

    public function edit(User $user): View
    {
        return view("users.edit", compact("user"));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'cargo' => 'nullable|min:5|max:100',
            'cpf' => 'required|unique:users,cpf,' . $user->id,
            'biografia' => 'nullable|min:10',
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
            'alt' => 'nullable|min:5|max:255',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ], [
            'cpf.unique' => 'CPF já cadastrado.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'name.required' => 'O campo nome é obrigatório.',
            'name.min' => 'O campo nome deve ter no mínimo 3 caracteres.',
            'name.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'cargo.max' => 'O campo cargo deve ter no máximo 100 caracteres.',
            'biografia.min' => 'O campo biografia deve ter no mínimo 10 caracteres.',
            'linkedin.url' => 'O campo linkedin deve ser uma URL válida.',
            'github.url' => 'O campo github deve ser uma URL válida.',
            'alt.min' => 'O campo alt deve ter no mínimo 5 caracteres.',
            'alt.max' => 'O campo alt deve ter no máximo 255 caracteres.',
            'imagem.image' => 'O arquivo deve ser uma imagem.',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo: jpeg, png, jpg, gif, svg.',
            'imagem.max' => 'O arquivo deve ter no máximo 2048 KB.',
        ]);
    
        $entrada = $request->all();
        $entrada['ativo'] = $request->has('ativo') ? $request->ativo : false;
    
        if ($request->has('cropped_image') && $request->cropped_image) {
            $image_parts = explode(";base64,", $request->cropped_image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = uniqid() . '.png';
            $imageFullPath = sys_get_temp_dir() . '/' . $imageName;
            file_put_contents($imageFullPath, $image_base64);
    
            $uploader = new ImageUploader();
            $uploader->setCompression(30);
            $uploader->setResolution(160);
            $uploader->setDestinationPath('users/');
            $entrada['imagem'] = $uploader->upload(new \Illuminate\Http\File($imageFullPath), $user->imagem);
        } else {
            unset($entrada['imagem']);
        }
    
        $user->update($entrada);
    
        return redirect()->route("users.index")
            ->with("success", "Usuário atualizado com sucesso.");
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->imagem) {
                $imagePath = public_path('imagens/users/' . $user->imagem);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $user->delete();

            $users = User::paginate(5);

            if (request()->ajax()) {
                return response()->json([
                    'table' => view('users.table', compact('users'))->render()
                ]);
            }
          
            return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso.');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao excluir o usuário.'], 500);
        }
    }
}