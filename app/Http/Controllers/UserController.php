<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $id = $user->id;
        $name = $user->name;
        $email = $user->email;
        $photo = $user->photo;

        return response()->json([
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'photo' => $photo
        ]);
    }

    public function showAll()
    {
        $user = Auth::user();

        $users = User::where('id', '!=', $user->id)->get();

        return response()->json([
            'users' => $users
        ]);
    }


    public function formUpdateNameEmail()
    {
        return view('update_name_email');
    }
    public function formUpdatePassword()
    {
        return view('update_password');
    }
    public function formUpdatePhoto()
    {
        return view('update_photo');
    }


    public function updateNameEmail(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email' . $user->id,
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        $user->save();

        return response()->json([
            'response' => 'Nom et email mis a jour avec succes.'
        ]);
    }
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Le mot de passe actuel est incorrect.');
                    }
                },
            ],
            'new_password' => 'required|string|min:8',
        ]);

        $user->password = $validated['new_password'];

        $user->save();

        return response()->json([
            'response' => 'Mot de passe mis a jour avec succes.'
        ]);
    }
    public function updatePhoto(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'photo' => 'image|max:20480|dimensions:max_width=4096,max_height=4096'
        ]);

        $userId = $user->id;

        $imageFile = $validated['photo'];

        $basePath = 'images'; // Dossier relative par rapport au dossier public

        $newFileName = 'user_id' . "_" . $userId . "_" . date('Ymd_His') . '.' . $imageFile->getClientOriginalExtension();

        $filePath = $imageFile->move($basePath, $newFileName);

        $user->photo = $filePath;

        $user->save();

        return response()->json([
            'response' => 'Photo mis a jour avec succes.',
            'file_path' => $basePath . '/' . $newFileName,
        ]);
    }



    public function formDestroyPhoto()
    {
        return view('destroy_photo_form');
    }
    public function destroyPhoto()
    {
        $user = Auth::user();

        if ($user->photo) {

            $photoPath = public_path($user->photo);

            if (file_exists($photoPath)) {
                unlink($photoPath);
                $user->photo = null;
                $user->save();

                return response()->json([
                    'response' => 'Photo supprime avec succes.'
                ]);
            }
        }

        return response()->json([
            'response' => 'Aucune photo pour supprimer.'
        ]);
    }
}
