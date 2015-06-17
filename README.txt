Instalacja:
1. zainstalowac na komputerze oprogramowanie composer
2. skopiowaæ folder z projektem do folderu htdocs
2b. ewentualnie wykonac komende `git clone https://github.com/jlzpi/zpi.git` (wymaga gita)
3. zedytowaæ plik backend/app/config/parameters.yml.dist:
	database_host: nr ip do bazy danych		(np. 127.0.0.1)
	database_port: port na którym dzia³a baza	(~ oznacza domyœlny)
	database_user: nazwa u¿ytkownika do bazy	(np. root)
	database_password: has³o do u¿ytkownika		(np. toor)
4. uruchomiæ skrypt `sh start` który utworzy bazê danych i skonfiguruje symfony (wymaga composera)
