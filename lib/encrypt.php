<?php

function encrypt($secret_key, $string){

  // Create the initialization vector for added security.
  //$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);

  // Encrypt $string
  //$encrypted_string = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secret_key, $string, MCRYPT_MODE_CBC, $iv);
  $encrypted_string = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secret_key, $string, MCRYPT_MODE_ECB);
  $encoded_string = base64_encode($encrypted_string);


  return $encoded_string;

}

function decrypt($secret_key, $encrypted_string){

  // Create the initialization vector for added security.
  //$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);

  // Decrypt $string
  //$decrypted_string = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secret_key, $encrypted_string, MCRYPT_MODE_CBC, $iv);
  $decoded_string = base64_decode($encrypted_string);
  $decrypted_string = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secret_key, $decoded_string, MCRYPT_MODE_ECB);
  $decrypted_string = trim($decrypted_string, "\0..\32");

  return $decrypted_string;

}
?>
