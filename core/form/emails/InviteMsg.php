<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@gmail.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 * DESCRIPTION: template used for phpmailer
 */

namespace app\core\form\emails;

class InviteMsg
{
    public string $subject = '';
    public string $message = '';
    public string $altBody = '';

    /**
     * @param string $message
     */
    public function __construct(string $registerHref, string $domainHref, string $email)
    {
        $this->subject = 'An invitation to Trackzy';
        $this->message = '
<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title></title>
    <meta name="description" content="Invitation email">
    <style type="text/css">
    a:hover {text-decoration: underline !important;}
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0; background-color: #f2f3f8;" leftmargin="0">
    <!--100% body table-->
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"">
        <tr>
            <td>
                <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
                    align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                          <a href="' . $domainHref . '" title="logo" target="_blank">
                            <img width="60" src="' . $domainHref . '/img/trackzy-logo.png" title="logo" alt="logo">
                          </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px;">
                                        <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;">Trackzy invitation</h1>
                                        <span
                                            style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px; text-align:left;">
                                        <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
    Hello ' . $email . ', you have been invited to join Trackzy. How cool is that!
                                        </p>
                                        <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
    You can use the following button to complete your registration:
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px; text-align:center;">
                                        <a href="' . $registerHref . '"
                                            style="background:#007bff;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">
                                            Register
                                            </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px; text-align:left;">
                                        <p style="color:#455056; font-size:15px;line-height:24px; margin-top:10px;">
    Thanks. <br>
The Trackzy Team
</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--/100% body table-->
</body>
</html>';
        $this->altBody =
            'Hello ' .
            $email .
            ', visit ' .
            $registerHref .
            ' to register at Trackzy. Thanks from The Trackzy Team';
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getAltBody(): string
    {
        return $this->altBody;
    }
}