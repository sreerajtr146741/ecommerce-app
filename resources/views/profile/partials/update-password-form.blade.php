<form method="POST" action="/update-password">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Current password</label>
        <input type="password" class="form-control" name="current_password" required>
    </div>

    <div class="mb-3">
        <label class="form-label">New password</label>
        <input type="password" class="form-control" name="password" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Confirm password</label>
        <input type="password" class="form-control" name="password_confirmation" required>
    </div>

    <button class="btn btn-primary">Update Password</button>
</form>
