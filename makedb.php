<?php
$stderr = fopen('php://stderr', 'w');
if (strpos($argv[1], ':') !== false)
{
	list($host, $port) = explode(':', $argv[1], 2);
}
else
{
	$host = $argv[1];
	$port = 3306;
}
$maxTries = 10;
do
{
	fwrite($stderr, "$host\n$argv[2]\n$argv[3]\n$argv[4]");

	$mysql = new mysqli($host, $argv[2], $argv[3], $argv[4]);
	if ($mysql->connect_error)
	{
		fwrite($stderr, "\nMySQL Connection Error: ({$mysql->connect_errno}) {$mysql->connect_error}\n");
		--$maxTries;
		if ($maxTries <= 0)
		{
			exit(1);
		}
		sleep(3);
	}
}
while ($mysql->connect_error);
fwrite($stderr, "MySQL Database en linea\n");
fwrite($stderr, "Cargando db.sql a la base de datos tpl\n");
$commands = file_get_contents('/db.sql');   
$mysql->multi_query($commands);
fwrite($stderr, "Backup cargado\n");
$mysql->close();
