<?php
if ($_GET['response_code']==1)
{
echo "Thank you for your purchase! Transaction id: ".htmlentities($_GET['transaction_id']);}
else
{
echo "Sorry, an error occurred: " . htmlentities($_GET['response_reason_text']);
}
?>
