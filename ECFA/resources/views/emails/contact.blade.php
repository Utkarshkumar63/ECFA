<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Inquiry | ECFA Bihar</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;-webkit-font-smoothing: antialiased;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">

        <!-- Premium Header Section -->
        <tr>
            <td align="center" style="padding: 50px 20px; background-color: #0f172a; background-image: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);">
                <div style="background-color: rgba(251, 191, 36, 0.1); border: 1px solid rgba(251, 191, 36, 0.3); display: inline-block; padding: 8px 16px; border-radius: 50px; margin-bottom: 20px;">
                    <span style="color: #fbbf24; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px;">New Website Inquiry</span>
                </div>
                <h1 style="color: #ffffff; margin: 0; font-size: 32px; font-weight: 900; letter-spacing: -1.5px; text-transform: uppercase;">ECFA <span style="color: #fbbf24;">BIHAR</span></h1>
                <p style="color: #94a3b8; margin: 10px 0 0 0; font-size: 14px; font-weight: 500; letter-spacing: 1px;">East Champaran Fencing Association</p>
            </td>
        </tr>

        <!-- Main Body Section -->
        <tr>
            <td style="padding: 40px 50px;">
                <h2 style="color: #1e293b; margin: 0 0 30px 0; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">Message Details</h2>

                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <!-- Sender Name -->
                    <tr>
                        <td style="padding-bottom: 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="40" valign="top" style="font-size: 20px;">👤</td>
                                    <td>
                                        <p style="margin: 0; color: #64748b; font-size: 11px; text-transform: uppercase; font-weight: 800; letter-spacing: 1.5px;">Full Name</p>
                                        <p style="margin: 4px 0 0 0; color: #0f172a; font-size: 17px; font-weight: 700;">{{ $details['name'] }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Email Address -->
                    <tr>
                        <td style="padding-bottom: 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="40" valign="top" style="font-size: 20px;">📧</td>
                                    <td>
                                        <p style="margin: 0; color: #64748b; font-size: 11px; text-transform: uppercase; font-weight: 800; letter-spacing: 1.5px;">Email Address</p>
                                        <p style="margin: 4px 0 0 0; color: #4f46e5; font-size: 17px; font-weight: 700;">{{ $details['email'] }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Subject -->
                    <tr>
                        <td style="padding-bottom: 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="40" valign="top" style="font-size: 20px;">📌</td>
                                    <td>
                                        <p style="margin: 0; color: #64748b; font-size: 11px; text-transform: uppercase; font-weight: 800; letter-spacing: 1.5px;">Subject</p>
                                        <p style="margin: 4px 0 0 0; color: #0f172a; font-size: 17px; font-weight: 700;">{{ $details['subject'] }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Message Content -->
                    <tr>
                        <td style="padding: 30px; background-color: #f8fafc; border-radius: 20px; border: 1px solid #e2e8f0;">
                            <p style="margin: 0 0 15px 0; color: #64748b; font-size: 11px; text-transform: uppercase; font-weight: 800; letter-spacing: 1.5px;">Message Content</p>
                            <div style="color: #334155; font-size: 16px; line-height: 1.8; font-style: italic; color: #1e293b;">
                                "{{ $details['message'] }}"
                            </div>
                        </td>
                    </tr>
                </table>

                <!-- Action Button -->
                <div style="margin-top: 50px; text-align: center;">
                    <a href="mailto:{{ $details['email'] }}" style="display: inline-block; padding: 18px 40px; background-color: #4f46e5; color: #ffffff; text-decoration: none; border-radius: 14px; font-weight: 800; font-size: 14px; text-transform: uppercase; letter-spacing: 2px; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);">
                        Reply To Message
                    </a>
                </div>
            </td>
        </tr>

        <!-- Footer Section -->
        <tr>
            <td style="padding: 40px; background-color: #f8fafc; text-align: center; border-top: 1px solid #f1f5f9;">
                <div style="margin-bottom: 20px;">
                    <a href="{{ url('/') }}" style="color: #6366f1; text-decoration: none; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">Visit Official Website</a>
                </div>
                <p style="margin: 0; color: #94a3b8; font-size: 12px; line-height: 1.5;">This is an automated notification from the ECFA Motihari Website portal. Please do not reply directly to this system email.</p>
                <div style="margin-top: 25px; padding-top: 25px; border-top: 1px solid #e2e8f0;">
                    <p style="margin: 0; color: #475569; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">© {{ date('Y') }} ECFA BIHAR. Motihari Unit.</p>
                </div>
            </td>
        </tr>
    </table>
    <div style="text-align: center; padding-bottom: 40px;">
        <p style="color: #94a3b8; font-size: 11px;">East Champaran, Bihar, India</p>
    </div>
</body>
</html>
