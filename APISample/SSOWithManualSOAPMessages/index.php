<?php
session_start();
?>
<html>
<head>
 <title>SSO With Manual SOAP Messages</title>   
</head>    
 <body>
       <form method="post" action="RedirectToPortal.php">
       <span style="color:red;"><?php if(isset($_SESSION['loginerr'])){ echo $_SESSION['loginerr'];$_SESSION['loginerr']='';}?></span>
        <h2>Portal Single Sign On Sample</h2>
        <table width="80%" cellpadding="5" cellspacing="5">            
            <tr>
                <td align="left"> Portal User Name:</td>
                <td align="left"><input type="text" name="portalusername" id="portalusername"></td>
            </tr>          
            <tr>
               <td align="left" colspan="2">
                <input type="submit" name="submit" value="Login">                    
               </td>               
           </tr>
        </table>       
       </form> 
 </body>   
</html>