<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    {{-- yk_-7J?oLeYU --}}
</head>

<body>
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
            <td align="center" bgcolor="#f7f7f7" style="padding: 40px 0 30px 0;">
                <img src="{{ asset('img/company/nug.png') }}" alt="Your Logo" width="150">
            </td>
        </tr>
        <tr>
            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td>
                            <h1>Change Password</h1>
                            <p>Dear {{ $full_name }},</p>
                            <p>We have received a request to change your password. To complete the process, please click
                                the button below:</p>
                            <p><a href="{{ route('user.profile.accept-changed-password', $id) }}?action={{ $email }}&validation={{ $app }}"
                                    style="background-color: #007bff; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Reset
                                    Your Password</a></p>
                            <p>If you did not make this request, please ignore this email, and your password will remain
                                unchanged.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f7f7f7" style="padding: 20px 30px 20px 30px;">
                <p>If you need any assistance or have any questions, please contact our support team at <a
                        href="mailto:info@nugcreative.my.id">info@nugcreative.my.id</a>.</p>
            </td>
        </tr>
    </table>
</body>

</html>
