<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted Successfully</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f8fafc; line-height: 1.6;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f8fafc;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <!-- Main Container -->
                <table role="presentation" style="max-width: 600px; width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07); overflow: hidden;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); padding: 50px 40px; text-align: center;">
                            <div style="font-size: 64px; margin-bottom: 20px;">✅</div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 32px; font-weight: 700; letter-spacing: -0.5px;">Application Received!</h1>
                            <p style="margin: 10px 0 0 0; color: rgba(255, 255, 255, 0.95); font-size: 18px; font-weight: 500;">Successfully Submitted</p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 50px 40px;">
                            <h2 style="margin: 0 0 20px 0; color: #1e293b; font-size: 24px; font-weight: 600;">Dear {{ $student_name }},</h2>
                            
                            <p style="margin: 0 0 20px 0; color: #475569; font-size: 16px; line-height: 1.7;">
                                Thank you for submitting your admission application to <strong>NCTU</strong>! 🎓
                            </p>
                            
                            <p style="margin: 0 0 30px 0; color: #475569; font-size: 16px; line-height: 1.7;">
                                We have successfully received your application and it is now <strong>under review</strong> by our admissions committee.
                            </p>

                            <!-- Application ID Box -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 35px 0;">
                                <tr>
                                    <td style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 12px; padding: 35px; text-align: center;">
                                        <p style="margin: 0 0 12px 0; color: rgba(255, 255, 255, 0.95); font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px;">Your Application ID</p>
                                        <p style="margin: 0; color: #ffffff; font-size: 36px; font-weight: 800; font-family: 'Courier New', monospace; letter-spacing: 3px; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">#{{ str_pad($application_id, 6, '0', STR_PAD_LEFT) }}</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Track Application Info -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 30px 0;">
                                <tr>
                                    <td style="background-color: #f5f3ff; border-left: 4px solid #8b5cf6; border-radius: 8px; padding: 20px 24px;">
                                        <p style="margin: 0; color: #5b21b6; font-size: 15px; line-height: 1.6;">
                                            <strong style="color: #6d28d9;">📊 Track Your Application:</strong> You can check the status of your application anytime by logging into your student portal. We will notify you via email once a decision has been made.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- What Happens Next -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 35px 0;">
                                <tr>
                                    <td style="background-color: #f8fafc; border-radius: 12px; padding: 30px;">
                                        <h3 style="margin: 0 0 20px 0; color: #1e293b; font-size: 19px; font-weight: 600;">📋 What Happens Next:</h3>
                                        <table role="presentation" style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="padding: 8px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #8b5cf6; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; margin-right: 12px;">1</span>
                                                    Our admissions team will carefully review your application
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #8b5cf6; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; margin-right: 12px;">2</span>
                                                    You will receive an email notification once a decision is made
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #8b5cf6; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; margin-right: 12px;">3</span>
                                                    Check your student portal regularly for status updates
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #475569; font-size: 15px; line-height: 1.6;">
                                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #8b5cf6; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; margin-right: 12px;">4</span>
                                                    Ensure your contact information is up to date
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Timeline Info -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 30px 0;">
                                <tr>
                                    <td style="background-color: #eff6ff; border-left: 4px solid #3b82f6; border-radius: 8px; padding: 20px 24px;">
                                        <p style="margin: 0; color: #1e40af; font-size: 15px; line-height: 1.6;">
                                            <strong style="color: #1e3a8a;">⏰ Review Timeline:</strong> Applications are typically reviewed within <strong>5-10 business days</strong>. We appreciate your patience during this process.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 30px 0 0 0; color: #475569; font-size: 16px; line-height: 1.7;">
                                Thank you for choosing NCTU. We look forward to reviewing your application! 🌟
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
                            <p style="margin: 0; color: #94a3b8; font-size: 13px;">For questions, contact: <a href="mailto:admissions@nctu.edu.eg" style="color: #8b5cf6; text-decoration: none;">admissions@nctu.edu.eg</a></p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
