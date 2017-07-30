<?php

class index_controller extends \core\m_controller\m_controller
{
    public function act_socket_server() {
        $users = array();
        $room_fds = array();
        $fd_room = array();
        $server = new swoole_websocket_server("0.0.0.0", 9501);

        $server->set(array(
            'task_worker_num' => 8,
        ));

        $server->on('open', function (swoole_websocket_server $server, $request) {
            global $users;
            $users[$request->fd] = $request;
            echo "server: handshake success with fd{$request->fd}\n";
        });

        $server->on('message', function (swoole_websocket_server $server, $frame) {
            echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";

            global $room_fds;
            $user_mod = $this->load_model('user');


            $data = json_decode($frame->data, true);
            $room_id = $data['room_id'];
            $user_id = $data['user_id'];
            $user = $user_mod->get_user_by_id($user_id);

            if(!$user) {
                $username = "未知";
            } else {
                $username = $user['user_name'];
            }

            $msg = $data['msg'];

            if(!isset($data['act'])) return;

            switch ($data['act']) {
                case 'init':
                    $msg = "登录成功";
                    global $fd_room;
                    $fd_room[$frame->fd] = $room_id;

                    $room_fds[$room_id][$frame->fd] = $frame->fd;
                    break;
                case 'msg':
                    break;
                default:
                    break;
            }

            if(!isset($room_fds[$room_id])) return false;

            $current_room_fds = $room_fds[$room_id];
            $server->task(array('current_room_fds' => $current_room_fds, 'user_id' => $user_id, 'username' => $username, 'msg' => $msg));
        });

        $server->on('close', function ($ser, $fd) {
            global $room_fds;
            global $fd_room;

            $room_id = isset($fd_room[$fd])? $fd_room[$fd]:'';
            unset($room_fds[$room_id][$fd]);
            echo "client {$fd} closed\n";
        });

        $server->on('task', function (swoole_websocket_server $server, $task_id, $from_id, $data) {
            $current_room_fds = $data['current_room_fds'];
            $user_id = $data['user_id'];
            $msg = $data['msg'];
            $username = $data['username'];

            foreach ($current_room_fds as $room_fd) {
                $send_data = array('msg_user_id' => $user_id, 'data' => $msg, 'username' => $username);
                $server->push($room_fd, json_encode($send_data));
            }

        });

        $server->on('Finish', function (swoole_server $serv, $task_id, $data) {
            echo "Task#$task_id finished, data_len=".strlen($data).PHP_EOL;
        });

        $server->start();

    }

    function act_socket_client() {
        $host = '127.0.0.1';
        $prot = 9501;
        $client = new \lib\m_web_socket\WebSocketClient($host, $prot);
        $data = $client->connect();

        while (true) {
            $client->send("{\"user_id\":1,\"room_id\":1,\"act\":\"init\",\"msg\":\"\"}");
            $tmp = $client->recv();
            break;
            sleep(1);
        }

        echo PHP_EOL . "======" . PHP_EOL;
        sleep(1);
        echo 'finish' . PHP_EOL;
    }

    public function act_login_post() {
        $username = isset($_POST['username']) ? $_POST['username'] : "";
        $password = isset($_POST['password']) ? $_POST['password'] : "";

        $user_mod = $this->load_model('user');


        $user = $user_mod->check_user_by_password($username, $password);

        session_start();

        $_SESSION['user'] = $user;

        $index_url = $this->create_url('socket/index/index');
        header('Location:' . $index_url);
    }

    public function act_login() {
        $post_url = $this->create_url('socket/index/login_post');
        $this->view('socket/login', array('post_url' => $post_url));
        $this->display();
    }

    public function act_index() {
        $this->view('socket/index');
        $this->display();
    }
}