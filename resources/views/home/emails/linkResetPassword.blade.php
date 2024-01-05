<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset password</title>
    <style>
        div {
            display: flex;
            justify-content: center;
        }
    
        p {
            margin-right: 16px;
            font-size: 16px;
        }
    
        a {
            text-decoration: none;
            display: block;
            font-weight: bold;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div>
        <p>Để reset mật khẩu, hãy ấn vào </p>
        <a href="{{ route('auth.resetPassword', $token) }}">đây</a>
    </div>
</body>
</html>
