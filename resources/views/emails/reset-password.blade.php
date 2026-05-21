<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f8fafc; line-height: 1.6;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f8fafc;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <!-- Main Container -->
                <table role="presentation" style="max-width: 600px; width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07); overflow: hidden;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 50px 40px; text-align: center;">
                            <div style="font-size: 64px; margin-bottom: 20px;">🔐</div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 32px; font-weight: 700; letter-spacing: -0.5px;">Reset Your Password</h1>
                            <p style="margin: 10px 0 0 0; color: rgba(255, 255, 255, 0.95); font-size: 18px; font-weight: 500;">Secure Account Recovery</p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 50px 40px;">
                            <h2 style="margin: 0 0 20px 0; color: #1e293b; font-size: 24px; font-weight: 600;">Hello {{ $userName }},</h2>
                            
                            <p style="margin: 0 0 20px 0; color: #475569; font-size: 16px; line-height: 1.7;">
                                We received a request to reset the password for your <strong>NCTU</strong> account. If you made this request, click the button below to set a new password.
                            </p>

                            <!-- Reset Button -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 35px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $resetUrl }}" style="display: inline-block; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: #ffffff; text-decoration: none; padding: 16px 48px; border-radius: 10px; font-size: 16px; font-weight: 600; box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3); transition: all 0.3s ease;">
                                            Reset My Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Security Notice -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 30px 0;">
                                <tr>
                                    <td style="background-color: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 8px; padding: 20px 24px;">
                                        <p style="margin: 0; color: #92400e; font-size: 15px; line-height: 1.6;">
                                            <strong style="color: #78350f;">⏰ Time Sensitive:</strong> This password reset link will expire in <strong>60 minutes</strong> for security reasons. If you need a new link, please request another password reset.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Alternative Link -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 30px 0;">
                                <tr>
                                    <td style="background-color: #f8fafc; border-radius: 12px; padding: 25px;">
                                        <p style="margin: 0 0 12px 0; color: #1e293b; font-size: 15px; font-weight: 600;">Button not working?</p>
                                        <p style="margin: 0 0 12px 0; color: #64748b; font-size: 14px; line-height: 1.6;">Copy and paste this link into your browser:</p>
                                        <p style="margin: 0; word-break: break-all;">
                                            <a href="{{ $resetUrl }}" style="color: #3b82f6; text-decoration: none; font-size: 13px;">{{ $resetUrl }}</a>
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Didn't Request -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 30px 0;">
                                <tr>
                                    <td style="background-color: #fef2f2; border-left: 4px solid #ef4444; border-radius: 8px; padding: 20px 24px;">
                                        <p style="margin: 0; color: #7f1d1d; font-size: 15px; line-height: 1.6;">
                                            <strong style="color: #991b1b;">🛡️ Didn't request this?</strong> If you didn't request a password reset, please ignore this email or contact our support team immediately. Your password will remain unchanged.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Security Tips -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 35px 0;">
                                <tr>
                                    <td style="background-color: #f8fafc; border-radius: 12px; padding: 30px;">
                                        <h3 style="margin: 0 0 20px 0; color: #1e293b; font-size: 19px; font-weight: 600;">🔒 Security Tips:</h3>
                                        <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="padding: 8px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #3b82f6; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; margin-right: 12px;">1</span>
                                                    Use a strong, unique password (at least 8 characters)
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #3b82f6; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; margin-right: 12px;">2</span>
                                                    Never share your password with anyone
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #3b82f6; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; margin-right: 12px;">3</span>
                                                    Avoid using the same password across multiple sites
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #3b82f6; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; margin-right: 12px;">4</span>
                                                    Contact support if you notice any suspicious activity
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #e2e8f0;">
                                <p style="margin: 0 0 5px 0; color: #1e293b; font-size: 15px; font-weight: 600;">Best regards,</p>
                                <p style="margin: 0; color: #64748b; font-size: 15px;">Security Team</p>
                                <p style="margin: 0; color: #64748b; font-size: 15px; font-weight: 600;">{{ config('app.name') }}</p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #1e293b; padding: 35px 40px; text-align: center;">
                            <p style="margin: 0 0 8px 0; color: #ffffff; font-size: 16px; font-weight: 600;">{{ config('app.name') }}</p>
                            <p style="margin: 0 0 15px 0; color: #94a3b8; font-size: 13px;">National College of Technology University</p>
                            <p style="margin: 0 0 5px 0; color: #94a3b8; font-size: 13px;">This is an automated security message. Please do not reply to this email.</p>
                            <p style="margin: 0; color: #94a3b8; font-size: 13px;">For support, contact: <a href="mailto:support@nctu.edu.eg" style="color: #3b82f6; text-decoration: none;">support@nctu.edu.eg</a></p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
