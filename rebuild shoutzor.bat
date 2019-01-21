docker stop shoutzor
docker rm shoutzor
docker build -t shoutzor .
docker run -d --name shoutzor -p 80:80 -p 8000:8000 shoutzor
