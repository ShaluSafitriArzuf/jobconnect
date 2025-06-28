<h2>Register</h2>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <input type="text" name="name" placeholder="Nama">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">

    <select name="role">
        <option value="user">User</option>
        <option value="company">Company</option>
        <option value="admin">Admin</option>
    </select>

    <button type="submit">Daftar</button>
</form>
