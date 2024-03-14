<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("grids.inc.php");
        use_unit("comctrls.inc.php");
        use_unit("menus.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class UScrollBar extends Page
        {
                public $ScrollBar1 = null;
                public $Label1 = null;
                public $Button3 = null;
                public $Button2 = null;
                public $Button1 = null;

                function Button3Click($sender, $params)
                {
                        $this->ScrollBar1->Min=0;
                        $this->ScrollBar1->Max=600;
                }

                function Button2Click($sender, $params)
                {
                        if ($this->ScrollBar1->Kind==sbHorizontal)
                        {
                                $this->ScrollBar1->Kind=sbVertical;
                        }
                        else
                        {
                                $this->ScrollBar1->Kind=sbHorizontal;
                        }
                }

                function Button1Click($sender, $params)
                {
                        $this->ScrollBar1->Position=200;
                        $this->Label1->Caption=$this->ScrollBar1->Position;
                }
        }

        global $application;

        global $UScrollBar;

        //Creates the form
        $UScrollBar=new UScrollBar($application);

        //Read from resource file
        $UScrollBar->loadResource(__FILE__);

        //Shows the form
        $UScrollBar->show();

?>
