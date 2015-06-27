<?php
/*
 *  
 * Get the number of netmask bits from a netmask in presentation format 
 * 
 * @param string $netmask Netmask in presentation format 
 *  
 * @return integer Number of mask bits 
 * @throws Exception 
 * 
 * IPV4 functions based on:
 * https://gist.github.com/jonavon/2028872
 * 
 * IPV6 validated using:
 * http://mikemackintosh.github.io/dTR-IP/
 *
 */ 
    
function countSetbits($int){
  $int = $int & 0xFFFFFFFF;
  $int = ( $int & 0x55555555 ) + ( ( $int >> 1 ) & 0x55555555 ); 
  $int = ( $int & 0x33333333 ) + ( ( $int >> 2 ) & 0x33333333 );
  $int = ( $int & 0x0F0F0F0F ) + ( ( $int >> 4 ) & 0x0F0F0F0F );
  $int = ( $int & 0x00FF00FF ) + ( ( $int >> 8 ) & 0x00FF00FF );
  $int = ( $int & 0x0000FFFF ) + ( ( $int >>16 ) & 0x0000FFFF );
  $int = $int & 0x0000003F;
  return $int;
 }
 
 
function validNetMask($netmask){
  $netmask = ip2long($netmask);
  if($netmask === false) return false;
  $neg = ((~(int)$netmask) & 0xFFFFFFFF);
  return (($neg + 1) & $neg) === 0;
 }
 
function netmask2bitmask($netmask){
    
  if(validNetMask($netmask)){
   
   echo  countSetBits(ip2long($netmask));
  }
  else {
      if (validateipv6($netmask)){
        echo 'Valid IPv6 '.$netmask;  
      }
      else
        echo 'Invalid Netmask '.$netmask;
 }
} 

  function validateipv6 ($ip) {
    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) {
        return true;
    }      
    return false;
}


echo "Resultado 1 255.255.0.0 : "; print netmask2bitmask('255.255.0.0') . "<br>";
//16
echo "Resultado 2 255.254.0.0 : "; print netmask2bitmask('255.254.0.0') . "<br>";
//15
echo "Resultado 3 255.252.0.0 : "; print netmask2bitmask('255.252.0.0') . "<br>";
//14
echo "Resultado 4 255.248.0.0 : "; print netmask2bitmask('255.248.0.0') . "<br>";
//14
echo "Resultado 5 255.240.0.0 : "; print netmask2bitmask('255.240.0.0') . "<br>";
//14
echo "Resultado 2 : "; print netmask2bitmask('ffff:ffff:ffff:ffc0:0:0:0:0') . "<br>";
//58 is a valid ipv6
echo "Resultado 2 : "; print netmask2bitmask(':ffff:ffff:ffc0:0:0:0:0') . "<br>";
//this is not a valid ipv6


?>