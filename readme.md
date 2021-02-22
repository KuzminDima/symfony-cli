### Installation

To start the project, you need to do the following steps:
1. Need to copy and rename the file .env.default to .env

1. Run docker containers using command: _docker-compose up --build_


### Available commands
1. Commands for adding a message to the queue: _docker-compose exec app php bin/console message:send_. This command will ask you to enter any message

1. To receive one unread message, use: _docker-compose exec app php bin/console message:receive_

1. To receive unread messages in real time, start the queue monitoring daemon: _docker-compose exec app php bin/console message:receiver-daemon:start_