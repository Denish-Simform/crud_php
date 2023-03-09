<?php
    class baseclass { 
        function somemethod() { 
            echo "base class";
        }
    }
    
    interface ibase{
        function somemethod();
    }
         
    trait mytrait{
        function somemethod() {
            echo "trait ";
        }
    }

    class myclass extends baseclass implements ibase {
        // use mytrait;
        // function somemethod() {
        //     echo "myclass";
        // }
    }

    $obj = new myclass();
    $obj->somemethod();
    session_start();
    $_SESSION["name"] = "denish";
?>
