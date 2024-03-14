<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        require_once("DbModule.php");
        use_unit("rawoutput.inc.php");
        use_unit("comctrls.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Cart extends Page
        {
        public $Total=null;
        public $Subtotal=null;
            public $Message=null;
            public $CartContents=null;

            protected $CartValue;

        function CartCreate($sender, $params)
        {
            $this->CartValue = $_COOKIE[ 'cart' ];

            $this->Message->Value = '';

            $items = explode( ',', $this->CartValue );

            $page = $_REQUEST[ 'page' ];
            $id = $_REQUEST[ 'id' ];

            if( $page == 'add' )
            {
                $already_added = false;
                $uid = $_REQUEST[ 'uid' ];

                if( count( $items ) > 0 )
                {
                    if( substr( $items[ 0 ], 0, 1 ) == 'U' )
                    {
                        $lastid = substr( $items[ 0 ], 1 );

                        if( $lastid == $uid )
                            $already_added = true;
                    }
                }

                if( !$already_added )
                {
                    for( $i = 0; $i < count( $items ); ++$i )
                    {
                        list( $cid, $quantity ) = explode( '=', $items[ $i ] );

                        if( $cid == $id )
                            break;
                    }

                    if( $i >= count( $items ) )
                    {
                        if( count( $items ) > 0 )
                        {
                            if( substr( $items[ 0 ], 0, 1 ) == 'U' )
                                $items[ 0 ] = 'U' . $uid;
                            else
                                array_unshift( $items, 'U' . $uid );
                        }
                        else
                        {
                            array_push( $items, 'U' . $uid );
                        }

                        array_push( $items, implode( '=', array( $id, 1 ) ) );
                    }
                    else
                    {
                        list( $cid, $quantity ) = explode( '=', $items[ $i ] );

                        $items[ $i ] = implode( '=', array( $id, $quantity + 1 ) );
                    }

                    $this->Message->Value = "Item #$id added.";
                }
                else
                {
                    $this->Message->Value = '';
                }
            }
            else if( $page == 'delete' )
            {
                for( $i = 0; $i < count( $items ); ++$i )
                {
                    list( $cid, $quantity ) = explode( '=', $items[ $i ] );

                    if( $cid == $id )
                        break;
                }

                if( $i < count( $items ) )
                    array_splice( $items, $i, 1 );

                $this->Message->Value = "Item #$id deleted.";
            }
            else if( $page == 'update' )
            {
                for( $i = 0; $i < count( $items ); ++$i )
                {
                    list( $cid, $quantity ) = explode( '=', $items[ $i ] );

                    $quantity = $_REQUEST[ 'quantity' . $cid ];

                    $items[ $i ] = implode( '=', array( $cid, $quantity ) );
                }
            }
            else
            {
                return;
            }

            $this->CartValue = implode( ',', $items );

            setcookie( 'cart', $this->CartValue );
        }

        function CartBeforeShow($sender, $params)
        {
            $items = explode( ',', $this->CartValue );

            $str = '';
            $subtotal = 0;

            foreach( $items as $data )
            {
                list( $id, $quantity ) = explode( '=', $data );

                if( empty( $id ) || substr( $id, 0, 1 ) == 'U' )
                    continue;

                GetDBModule()->Query1->close();

                GetDBModule()->Query1->SQL = "SELECT * FROM products WHERE ID = '" . mysql_real_escape_string( $id ) . "'";

                GetDBModule()->Query1->open();

                $str .= '<tr>';
                $str .= '<td>' . GetDBModule()->Query1->Name . '</td>';
                $str .= '<td><input type="text" name="quantity' . $id . '" value="' . $quantity . '" size="4"></td>';
                $str .= '<td width="50">$' . sprintf( "%01.2f", GetDBModule()->Query1->Price * $quantity ) . '</td>';
                $str .= '<td width="50"><a href="index.php?page=delete&id=' . $id . '">Delete</a></td>';
                $str .= "</tr>\r\n";

                $subtotal += GetDBModule()->Query1->Price * $quantity;
            }

            $this->CartContents->Value = $str;

            $this->Subtotal->Value = '$' . sprintf( "%01.2f", $subtotal );
            $this->Total->Value = '$' . sprintf( "%01.2f", $subtotal );
        }

}

        global $application;

        global $Cart;

        //Creates the form
        $Cart=new Cart($application);

        //Read from resource file
        $Cart->loadResource(__FILE__);

        //Shows the form
        $Cart->show();

?>
