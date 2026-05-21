<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Accepted</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f8fafc; line-height: 1.6;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f8fafc;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <!-- Main Container -->
                <table role="presentation" style="max-width: 600px; width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07); overflow: hidden;">
                    
                    <!-- Header with Logo/Brand -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 50px 40px; text-align: center;">
                            <div style="font-size: 64px; margin-bottom: 20px;">🎉</div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 32px; font-weight: 700; letter-spacing: -0.5px;">Congratulations!</h1>
                            <p style="margin: 10px 0 0 0; color: rgba(255, 255, 255, 0.95); font-size: 18px; font-weight: 500;">You've Been Accepted</p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 50px 40px;">
                            <h2 style="margin: 0 0 20px 0; color: #1e293b; font-size: 24px; font-weight: 600;">Dear {{ $student_name }},</h2>
                            
                            <p style="margin: 0 0 20px 0; color: #475569; font-size: 16px; line-height: 1.7;">
                                We are <strong style="color: #10b981;">thrilled to inform you</strong> that your admission application has been <strong>accepted</strong>! 🎊
                            </p>
                            
                            <p style="margin: 0 0 30px 0; color: #475569; font-size: 16px; line-height: 1.7;">
                                After careful review of your application, we are pleased to welcome you to <strong>NCTU</strong>. Your dedication and qualifications have truly impressed our admissions committee.
                            </p>

                            <!-- Student Code Box -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 35px 0;">
                                <tr>
                                    <td style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px; padding: 35px; text-align: center;">
                                        <p style="margin: 0 0 12px 0; color: rgba(255, 255, 255, 0.95); font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px;">Your Student Code</p>
                                        <p style="margin: 0; color: #ffffff; font-size: 36px; font-weight: 800; font-family: 'Courier New', monospace; letter-spacing: 3px; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">{{ $student_code }}</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Important Notice -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 30px 0;">
                                <tr>
                                    <td style="background-color: #f0fdf4; border-left: 4px solid #10b981; border-radius: 8px; padding: 20px 24px;">
                                        <p style="margin: 0; color: #065f46; font-size: 15px; line-height: 1.6;">
                                            <strong style="color: #047857;">⚠️ Important:</strong> Please save this student code securely. You'll need it for registration, accessing student services, and all future correspondence with the institution.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Next Steps -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 35px 0;">
                                <tr>
                                    <td style="background-color: #f8fafc; border-radius: 12px; padding: 30px;">
                                        <h3 style="margin: 0 0 20px 0; color: #1e293b; font-size: 19px; font-weight: 600;">📋 What's Next?</h3>
                                        <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="padding: 8px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #10b981; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; margin-right: 12px;">1</span>
                                                    Keep your student code safe and accessible
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #10b981; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; margin-right: 12px;">2</span>
                                                    Check your email regularly for enrollment instructions
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #10b981; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; margin-right: 12px;">3</span>
                                                    Prepare required documents for enrollment
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #10b981; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; margin-right: 12px;">4</span>
                                                    Contact our admissions office with any questions
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 30px 0 0 0; color: #475569; font-size: 16px; line-height: 1.7;">
                                We look forward to seeing you on campus and wish you every success in your academic journey! 🚀
                            </p>

                            <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #e2e8f0;">
                                <p style="margin: 0 0 5px 0; color: #1e293b; font-size: 15px; font-weight: 600;">Best regards,</p>
                                <p style="margin: 0; color: #64748b; font-size: 15px;">Admissions Office</p>
                                <p style="margin: 0; color: #64748b; font-size: 15px; font-weight: 600;">{{ config('app.name') }}</p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #1e293b; padding: 35px 40px; text-align: center;">
                            <p style="margin: 0 0 8px 0; color: #ffffff; font-size: 16px; font-weight: 600;">{{ config('app.name') }}</p>
                            <p style="margin: 0 0 15px 0; color: #94a3b8; font-size: 13px;">National College of Technology University</p>
                            <p style="margin: 0 0 5px 0; color: #94a3b8; font-size: 13px;">This is an automated message. Please do not reply to this email.</p>
                            <p style="margin: 0; color: #94a3b8; font-size: 13px;">For questions, contact: <a href="mailto:admissions@nctu.edu.eg" style="color: #10b981; text-decoration: none;">admissions@nctu.edu.eg</a></p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
