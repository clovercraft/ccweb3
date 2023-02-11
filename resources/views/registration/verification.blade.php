<div class="container mt-5">
    <h1>Minecraft verified!</h1>
    <h2>We just need a couple more details to wrap things up</h2>
    <label for="input-birthdate">Birthday</label>
    <input type="date" id="input-birthdate" name="birthdate" class="form-control mb-2" />
    <label for="input-pronouns">Pronouns</label>
    <input type="text" id="input-pronouns" name="pronouns" class="form-control mb-2" />
    <input type="hidden" id="input-user" name="user" value="{{ $authuser->id }}" />
    <button class="btn btn-primary" id="submit-verification">Verify</button>
</div>
