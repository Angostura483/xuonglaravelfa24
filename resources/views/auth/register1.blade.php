<form action="{{ route('register1') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Tên">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Mật khẩu">
    <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu">
    <button type="submit">Đăng ký</button>
</form>