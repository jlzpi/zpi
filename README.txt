Instalacja:
1. zainstalowac na komputerze oprogramowanie composer
2. skopiowa� folder z projektem do folderu htdocs
2b. ewentualnie wykonac komende `git clone https://github.com/jlzpi/zpi.git` (wymaga gita)
3. zedytowa� plik backend/app/config/parameters.yml.dist:
	database_host: nr ip do bazy danych		(np. 127.0.0.1)
	database_port: port na kt�rym dzia�a baza	(~ oznacza domy�lny)
	database_user: nazwa u�ytkownika do bazy	(np. root)
	database_password: has�o do u�ytkownika		(np. toor)
4. uruchomi� skrypt `sh start` kt�ry utworzy baz� danych i skonfiguruje symfony (wymaga composera)
