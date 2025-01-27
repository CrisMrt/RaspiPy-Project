cd /var/www/html/teste
sudo node record.js "arecord -f S16_LE -c1 -r44100 -D plughw:3,0 -d 5 /var/www/html/teste/conseguiste.wav"
