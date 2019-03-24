<?php

use App\Infrastructure\Server;
use App\Infrastructure\VirtualMachine;

require "vendor/autoload.php";

$server = new Server(3, 3, 3);
$vms = [
    new VirtualMachine(1, 1, 1), //1
    new VirtualMachine(1, 1, 1), //1
    new VirtualMachine(1, 1, 1), //1
    new VirtualMachine(3, 3, 3), //2
    new VirtualMachine(3, 3, 3), //3
    new VirtualMachine(1, 1, 1), //4
    new VirtualMachine(1, 1, 1), //4
    new VirtualMachine(2, 2, 2), //5
//    new VirtualMachine(12, 2, 2), //error
];
echo calculate($server, ...$vms).PHP_EOL;
