<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Account Has Been Created</title>
</head>
<body>
    <h1>Welcome to Building Management System</h1>
    
    <p>Hello {{ $user->name }},</p>
    
    <p>Your account has been created successfully. You can now access the system using the credentials below:</p>
    
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Password:</strong> {{ $defaultPassword }}</p>
    
    <p><strong>Login URL:</strong> {{ url('/login') }}</p>
    
    <p>We recommend changing your password after your first login for security purposes.</p>
    
    <p>If you have any questions or need assistance, please contact your building administrator.</p>
    
    <p>Thank you,</p>
    <p>Building Management System</p>
</body>
</html>