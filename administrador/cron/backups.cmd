echo off
rem Este script fue elaborado por Jose Luis Aranibar el 2008 en la Prefectura
g:
cd backup_sirc
set tmp=dbsirc
mkdir "%tmp%"
set fecha=(%date%)
set FECHA= %date% %time%
set FECHA=%FECHA:/=%
set FECHA=%FECHA: =%
set FECHA=%FECHA::=%
set FECHA=%FECHA:.=%

rename dbsirc "dbsirc(%FECHA%)"

c:
cd \
cd C:\xampp\mysql\data\dbsirc11

copy *.* "g:\backup_sirc\dbsirc(%FECHA%)"

