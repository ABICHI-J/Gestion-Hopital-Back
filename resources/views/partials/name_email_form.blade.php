<form method="post" action="{{ route('user.update.nameEmail') }}" enctype="multipart/form-data">

    @csrf

    <label for="name">Nom :</label>
    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required>
    @error('name')
    <div class="error">{{ $message }}</div>
    @enderror

    <br>

    <label for="email">Email :</label>
    <input type="email" name="email" value="{{ Auth::user()->email }}" required>
    @error('email')
    <div class="error">{{ $message }}</div>
    @enderror

    <br>

    <button type="submit">Mettre à jour</button>
</form>