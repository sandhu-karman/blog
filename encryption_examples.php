<html>
	<head>
		<title>Encryption Examples</title>
	</head>
	<body>

		<?php
		echo "<h3>Examples from <a href='http://www.w3schools.com/php/func_string_crypt.asp'>W3Schools</a> and crypt</h3>";
		// 2 character salt
		if (CRYPT_STD_DES == 1)
		{
			echo "Standard DES: ".crypt('something','st')."\n<br>";
		}
		else
		{
			echo "Standard DES not supported.\n<br>";
		}

		// 4 character salt
		if (CRYPT_EXT_DES == 1)
		{
			echo "Extended DES: ".crypt('something','_S4..some')."\n<br>";
		}
		else
		{
			echo "Extended DES not supported.\n<br>";
		}

		// 12 character salt starting with $1$
		if (CRYPT_MD5 == 1)
		{
			echo "MD5: ".crypt('something','$1$somethin$')."\n<br>";
		}
		else
		{
			echo "MD5 not supported.\n<br>";
		}

		// Salt starting with $2a$. The two digit cost parameter: 09. 22 characters
		if (CRYPT_BLOWFISH == 1)
		{
			echo "Blowfish: ".crypt('something','$2a$09$anexamplestringforsalt$')."\n<br>";
		}
		else
		{
			echo "Blowfish DES not supported.\n<br>";
		}

		// 16 character salt starting with $5$. The default number of rounds is 5000.
		if (CRYPT_SHA256 == 1)
		{
		echo "SHA-256: ".crypt('something','$5$rounds=5000$anexamplestringforsalt$')."\n<br>"; }
		else
		{
			echo "SHA-256 not supported.\n<br>";
		}

		// 16 character salt starting with $5$. The default number of rounds is 5000.
		if (CRYPT_SHA512 == 1)
		{
			echo "SHA-512: ".crypt('something','$6$rounds=5000$anexamplestringforsalt$')."\n<br>";
		}
		else
		{
			echo "SHA-512 not supported."."\n<br>";
		}
		
		echo "<h3>Example using password_hash() function and PASSWORD_BCRYPT</h3>";
		// password_hash ( string $password , integer $algo [, array $options ] )
		$password = password_hash( 'something', PASSWORD_BCRYPT); 
		echo "Using Hash and SHA512: ".$password."\n<br>";
		
		echo "<h3>Example using hash function and sha512</h3>";
		$password = hash("sha512", 'something'); 
		echo "Using Hash and SHA512: ".$password."\n<br>";
		
		
		?>
	</body>
</html>