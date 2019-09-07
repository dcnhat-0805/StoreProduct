<br>
<strong>Mã xác thực：{{ $adminPasswordReset->token }}</strong><br>
<br>
Vui lòng nhập key xác thực với màn hình. <br>
Nếu đầu vào không được hoàn thành trong vòng 30 phút, khóa xác thực sẽ không hợp lệ. <br>
<br>
※Nếu 30 phút trôi qua hoặc màn hình đặt lại mật khẩu đã bị đóng, <br>
vui lòng thử lại từ sau. <br>
{{--[ đặt lại mật khẩu<a href="{{ route(ADMIN_FORGET_PASSWORD, ['email' => $adminPasswordReset->email, 'token' => $adminPasswordReset->token]) }}">URL</a>]--}}
<br>
<br>
────────────────────<br>
※Email này được gửi dưới dạng trả lời tự động . <br>
Cảm ơn bạn !<br>
