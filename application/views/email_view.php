<?php
/*
 * Email template
 */
?>
<html>

<body bgcolor="ffffff">
<div align="center">
    <br>
    <table style="font-family: Georgia, 'Times New Roman', Times, serif; font-size: 12px; width: 580px; border: 10px solid #fafafa;" border="0" cellspacing="0" cellpadding="10" align="center" bgcolor="#FFFFFF">
        <tbody>
        <tr>
            <td style="font-family: Georgia, 'Times New Roman', Times, serif; font-size: 28px; border-top: 1px dashed #CCCCCC; color: #333333;"><?php echo!empty($subject) ? $subject : ''; ?></td>
        </tr>
        <tr><td><p></p></td></tr>
        <tr>
            <td style="color: #666666;" colspan="2">
                <?php echo!empty($message) ? $message : ''; ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>