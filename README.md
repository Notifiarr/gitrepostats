## Purpose

This was just something thrown together in a couple days so I can visualize GIT (not bound to GH) repositories all in one place with metrics I want to see. You're welcome to use it, or not.

## Install

Compose (adjust the port and volume path accordingly)
```
version: "2.1"
services:
  gitrepostats:
    container_name: gitrepostats
    image: ghcr.io/notifiarr/gitrepostats:main
    ports:
      - 9995:80/tcp
    environment:
      - TZ=America/New_York
    volumes:
      - /volume1/data/docker/gitrepostats/config:/config
```

## Screenshots
![image](https://github.com/Notifiarr/gitrepostats/assets/8321115/78b8c9b0-0de4-4f43-ab4c-b3ce483f8af6)
![image](https://github.com/Notifiarr/gitrepostats/assets/8321115/39c1a931-bef7-43c6-8251-72582c5fda0a)
![image](https://github.com/Notifiarr/gitrepostats/assets/8321115/f4ff66f7-78f7-4122-8401-e463951d1a74)
![image](https://github.com/Notifiarr/gitrepostats/assets/8321115/721751e6-da23-4c8f-8ace-10a0ba11d453)
![image](https://github.com/Notifiarr/gitrepostats/assets/8321115/6e6bde66-640f-4d9a-bd60-eecb8b9ae0c1)
![image](https://github.com/Notifiarr/gitrepostats/assets/8321115/cc46481f-9506-43de-b5a2-7e75f2f87ea0)
![image](https://github.com/Notifiarr/gitrepostats/assets/8321115/0bb204ed-c234-4a2d-b03d-11faff66e1c4)
