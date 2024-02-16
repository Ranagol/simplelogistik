<?php

namespace Modules;

abstract class FtpConnector {

    /**
     * This is the FTP server instance, that we will use to access the orders.
     */
    protected $ftpServer;

    /**
     * The name of the ftp connection. Example: PamyraOrdersTest, PamyraOrdersLive.
     *
     * @var string
     */
    protected string $connectionName;

}