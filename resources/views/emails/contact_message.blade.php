<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Contact Message</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { text-align: center; border-bottom: 2px solid #059669; padding-bottom: 15px; margin-bottom: 20px; }
        .header h3 { color: #0f172a; margin: 0; font-size: 20px; }
        .content p { color: #475569; line-height: 1.6; font-size: 14px; }
        table { width: 100%; margin-top: 15px; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; font-size: 14px; }
        th { background-color: #f1f5f9; width: 25%; font-weight: bold; color: #334155; }
        td { color: #475569; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3>EzProperty Contact Form</h3>
        </div>
        
        <div class="content">
            <p>Hello EzProperty Team,</p>
            <p>You have received a new message from your website contact form. Here are the details:</p>

            <table>
                <tr>
                    <th>Name</th>
                    <td>{{ $contactData['name'] }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $contactData['email'] }}</td>
                </tr>
                <tr>
                    <th>Subject</th>
                    <td>{{ $contactData['subject'] }}</td>
                </tr>
                <tr>
                    <th>Message</th>
                    <td>{{ $contactData['message'] }}</td>
                </tr>
            </table>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Ez Property. All rights reserved.</p>
        </div>
    </div>
</body>
</html>