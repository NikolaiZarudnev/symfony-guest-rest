up:
	docker compose up
sh:
	docker exec -it $(shell docker ps -qf "name=bnovo-php*") sh