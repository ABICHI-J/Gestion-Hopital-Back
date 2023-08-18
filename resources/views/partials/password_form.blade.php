<form method="post" action="{{ route('user.update.password') }}" enctype="multipart/form-data">

    @csrf

    <label for="current_password">Mot de passe actuel :</label>
    <input type="password" name="current_password" value="" required>
    @error('current_password')
    <div class="error">{{ $message }}</div>
    @enderror

    <br>

    <label for="new_password">Nouveau mot de passe :</label>
    <input type="password" name="new_password" value="" required>
    @error('new_password')
    <div class="error">{{ $message }}</div>
    @enderror

    <br>

    <button type="submit">Mettre à jour</button>

</form>