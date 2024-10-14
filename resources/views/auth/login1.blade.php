<form action="{{ route('login1') }}" method="POST">
    @csrf
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Mật khẩu">
    <button type="submit">Đăng nhập</button>
</form>