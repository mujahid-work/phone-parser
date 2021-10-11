<?php

class Connection
{
    public function connect()
    {
        $con = mysqli_connect("localhost", "root", "", "phone_db");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        return  $con;
    }
}
