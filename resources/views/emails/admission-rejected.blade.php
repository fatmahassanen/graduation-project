<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status Update</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f8fafc; line-height: 1.6;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f8fafc;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <!-- Main Container -->
                <table role="presentation" style="max-width: 600px; width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07); overflow: hidden;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #64748b 0%, #475569 100%); padding: 50px 40px; text-align: center;">
                            <div style="font-size: 64px; margin-bottom: 20px;">📋</div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 32px; font-weight: 700; letter-spacing: -0.5px;">Application Status Update</h1>
                            <p style="margin: 10px 0 0 0; color: rgba(255, 255, 255, 0.95); font-size: 18px; font-weight: 500;">Admission Decision</p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 50px 40px;">
                            <h2 style="margin: 0 0 20px 0; color: #1e293b; font-size: 24px; font-weight: 600;">Dear {{ $student_name }},</h2>
                            
                            <p style="margin: 0 0 20px 0; color: #475569; font-size: 16px; line-height: 1.7;">
                                Thank you for your interest in <strong>NCTU</strong> and for taking the time to submit your admission application.
                            </p>
                            
                            <p style="margin: 0 0 30px 0; color: #475569; font-size: 16px; line-height: 1.7;">
                                After careful consideration of your application, we regret to inform you that we are <strong>unable to offer you admission</strong> at this time.
                            </p>

                            @if(!empty($rejection_reason))
                            <!-- Rejection Reason Box -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 35px 0;">
                                <tr>
                                    <td style="background-color: #fef2f2; border-left: 4px solid #ef4444; border-radius: 8px; padding: 24px;">
                                        <p style="margin: 0 0 12px 0; color: #991b1b; font-size: 15px; font-weight: 700;">📌 Reason for Decision:</p>
                                        <p style="margin: 0; color: #7f1d1d; font-size: 15px; line-height: 1.6;">{{ $rejection_reason }}</p>
                                    </td>
                                </tr>
                            </table>
                            @endif

                            <!-- Reapplication Info -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 30px 0;">
                                <tr>
                                    <td style="background-color: #eff6ff; border-left: 4px solid #3b82f6; border-radius: 8px; padding: 20px 24px;">
                                        <p style="margin: 0; color: #1e40af; font-size: 15px; line-height: 1.6;">
                                            <strong style="color: #1e3a8a;">💡 You May Reapply:</strong> We encourage you to address the concerns mentioned above and consider reapplying in the future. You can submit a new application through your student portal.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Next Steps -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 35px 0;">
                                <tr>
                                    <td style="background-color: #f8fafc; border-radius: 12px; padding: 30px;">
                                        <h3 style="margin: 0 0 20px 0; color: #1e293b; font-size: 19px; font-weight: 600;">🔄 What You Can Do:</h3>
                                        <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="padding: 8px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #64748b; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; margin-right: 12px;">1</span>
                                                    Review the feedback provided above carefully
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #64748b; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; margin-right: 12px;">2</span>
                                                    Address any concerns or missing requirements
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #64748b; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; margin-right: 12px;">3</span>
                                                    Consider reapplying in the next admission cycle
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #64748b; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; margin-right: 12px;">4</span>
                                                    Contact our admissions office if you have questions
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 30px 0 0 0; color: #475569; font-size: 16px; line-height: 1.7;">
                                We appreciate your understanding and wish you the best in your educational pursuits. 🌟
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
                            <p style="margin: 0; color: #94a3b8; font-size: 13px;">For questions, contact: <a href="mailto:admissions@nctu.edu.eg" style="color: #3b82f6; text-decoration: none;">admissions@nctu.edu.eg</a></p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
