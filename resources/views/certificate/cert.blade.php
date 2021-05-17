<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>E-Cert | Momentum Internet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .bg {
            /* The image used */
            background-image: url("https://i.ibb.co/HP2C1yG/e-cert.png");

            /* Full height */
            height: 100%;

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        
    </style>
</head>
<body class="bg">
    <table role="presentation" border="1" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 40px 0 30px 0;">
                <img src="https://i.ibb.co/Pw5Wz90/logo-text.png" style="margin: 0; max-width:200px">
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 40px 0 30px 0;">
                <h1 style="margin: 0;">CERTIFICATE</h1>
                <h1 style="margin: 0;">OF COMPLETION</h1>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 40px 0 30px 0;">
                <p style="margin: 0;">This certifies that</p>
                <h3 style="margin: 0;"> {{ $student->first_name }} {{ $student->last_name }}</h3>
                <h5 style="margin: 0;"> ({{ $student->ic }})</h5>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 40px 0 30px 0;">
                <p style="margin: 0;"> has successfully completed the course</p>
                <h3 style="margin: 0;"> {{ $product->name }}</h3>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 40px 0 30px 0;">
                <p style="margin: 0;"> that was held on </p>
                <h3> {{ date('d/m/Y', strtotime($product->date_from)) }} &nbsp; - &nbsp; {{ date('d/m/Y', strtotime($product->date_to)) }}</h3>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 40px 0 30px 0;">
                <img src="https://i.ibb.co/5k9QRyk/certified-cop.png" style="max-width:200px;">
            </td>
            <td align="center" style="padding: 40px 0 30px 0;">
                <p style="margin: 0;">Row 7</p>
                <img src="https://i.ibb.co/7WDt18B/sign.png" style="max-width:80px; margin: 0;">
                <h3 style="margin: 0;">Najib Asaddok</h3>
                <p style="margin: 0;"> Chief Executive Officer (CEO)</p>
                <p style="margin: 0;"> Momentum Internet Sdn Bhd </p>
            </td>
        </tr>
    </table>
    
</body>
</html>