up:
	docker compose up
start:
	docker compose start
sh:
	docker exec -it $(shell docker ps -qf "name=bnovo-php*") bash