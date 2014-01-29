<?php


function ex_crypt($source)
{ 
	
	$key = "5&2fc8E2b2#15";
	$s = "";

	// Открывает модуль и создаёт IV 
	 $td = mcrypt_module_open ('des', '', 'ecb', '');
	 $key = substr ($key, 0, mcrypt_enc_get_key_size ($td));
	 $iv_size = mcrypt_enc_get_iv_size ($td);
	 $iv = mcrypt_create_iv ($iv_size, MCRYPT_RAND);

	// Инициализирует дескриптор шифрования и шифруем
	if (mcrypt_generic_init ($td, $key, $iv) != -1) 
	{
	$s = mcrypt_generic($td, $source);
	mcrypt_generic_deinit ($td);
	mcrypt_module_close ($td);
	}
	return $s; 
}

function ex_decrypt($source)
{

	
	$key = "5&2fc8E2b2#15";
	$s = "";

	// Открывает модуль и создаёт IV 
	$td = mcrypt_module_open ('des', '', 'ecb', '');
	$key = substr ($key, 0, mcrypt_enc_get_key_size ($td));
	$iv_size = mcrypt_enc_get_iv_size ($td);
	$iv = mcrypt_create_iv ($iv_size, MCRYPT_RAND);

	// Инициализирует дескриптор шифрования и дешифруем
	if (mcrypt_generic_init ($td, $key, $iv) != -1) 
	{
	$s = mdecrypt_generic ($td, $source);
	mcrypt_generic_deinit ($td);
	mcrypt_module_close ($td);
	}
	return $s; 
}
		
		?>