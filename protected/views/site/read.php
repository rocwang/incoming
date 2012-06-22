<table>
     <tr>
          <td>From:</td>
          <td><?php echo imap_utf8($overview->from); ?></td>
     </tr>
     <tr>
          <td>Date:</td>
          <td><?php echo $overview->date; ?></td>
     </tr>
     <tr>
          <td>Subject:</td>
          <td><?php echo imap_utf8($overview->subject); ?></td>
     </tr>
     <tr>
          <td colspan="2"><?php echo $body; ?></td>
     </tr>
</table>
