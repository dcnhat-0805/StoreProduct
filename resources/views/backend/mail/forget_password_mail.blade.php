<br>
<strong>Verification codes：{{ $adminPasswordReset->token }}</strong><br>
<br>
※We heard that you lost your StoreOnline password. Sorry about that! <br>
But don’t worry! You can use the following link to reset your password:
<br>
[<a href="{{ route(ADMIN_FORGET_PASSWORD, ['email' => $adminPasswordReset->email, 'token' => $adminPasswordReset->token]) }}">Reset Password</a>]
<br>
<br>
────────────────────<br>
※Thank you !<br>
The StoreOnline Team<br>
